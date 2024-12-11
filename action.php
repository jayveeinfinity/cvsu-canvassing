<?php
session_start();
require 'config.php';

if (isset($_POST['updateQuantity'])) {
    $pid = $_POST['pid']; // Product ID
    $newQty = $_POST['newQty']; // New Quantity

    // Check if the product ID and quantity are valid
    if (is_numeric($pid) && is_numeric($newQty) && $newQty > 0) {
        // Update the cart quantity in the database
        $stmt = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
        $stmt->bind_param('ii', $newQty, $pid); // 'ii' means both params are integers

        if ($stmt->execute()) {
            echo "Quantity updated successfully";
        } else {
            echo "Error updating quantity: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid data provided";
    }
}


// Update product quantity and total price in the cart
//  if (isset($_POST['updateTotalPrice'])) {
  //   $pid = $_POST['pid'];            // Product ID
  //   $productPrice = $_POST['productPrice']; // Product Price
  //   $newQty = $_POST['newQty'];       // New Quantity
   //  $newTotalPrice = $productPrice * $newQty;  // Calculate new total price

    // Update the cart with the new quantity and total price
   //  $stmt = $conn->prepare("UPDATE `cart` SET `qty` = ?, `total_price` = ? WHERE `id` = ?");
  //   $stmt->bind_param('idi', $newQty, $newTotalPrice, $pid);
   //  $stmt->execute();

  //   echo "Quantity updated successfully";  // Optional: to confirm success
   //  return;
// }

// Add product to cart
if (isset($_POST['action']) && $_POST['action'] == "addItemToList") {
    $pcode = $_POST['code'];

    // Check if product already exists in the cart
    $stmt = $conn->prepare("SELECT * FROM `product` WHERE `product_code` = ? LIMIT 1");
    $stmt->bind_param('s', $pcode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $pid = $row['id'];
    $pname = $row['product_name'];
    $description = $row['description'];
    $pprice = $row['product_price'];
    $pimage = $row['product_image'];
    $pqty = 1;

    $stmt = $conn->prepare("SELECT `product_code` FROM `cart` WHERE `product_code` = ?");
    $stmt->bind_param('s',$pcode);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_assoc();
    $code = $r['product_code'] ?? '';

    $user_id = $_SESSION['user_id'];

    if (!$code) {
		$query = $conn->prepare("INSERT INTO cart (`product_name`, `product_price`, `description`, `product_image`, `qty`, `total_price`, `product_code`, `user_id`) VALUES (?,?,?,?,?,?,?,?)");
		$query->bind_param('sdssidsi',$pname,$pprice,$description,$pimage,$pqty,$pprice,$pcode,$user_id);
		$query->execute();
	
		// Limit the product name to 20 characters
		$shortName = substr($description, 0, 20);
		if (strlen($description) > 20) {
			$shortName .= '...';  
		}
	
		echo '<div class="alert alert-success alert-dismissible mt-2">
					  <button type="button" class="close" data-dismiss="alert">
						<i class="bi bi-x-lg"></i>
					  </button>
					  <strong>' . $shortName . ' added to your paper!</strong>
				  </div>';
	} else {
		// Limit the product name to 20 characters
		$shortName = substr($description, 0, 20);
		if (strlen($description) > 20) {
			$shortName .= '...';  // Add ellipsis if the name is longer than 20 characters
		}
	
		echo '<div class="alert alert-danger alert-dismissible mt-2">
					  <button type="button" class="close" data-dismiss="alert">
						<i class="bi bi-x-lg"></i>
					  </button>
					  <strong>' . $shortName . ' is already added to your paper!</strong>
				  </div>';
	}
	
}

// Number of items in the cart
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
    $stmt = $conn->prepare('SELECT * FROM cart');
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    echo $rows;
}

// Remove a single item from the cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
    $stmt->bind_param('i',$id);
    $stmt->execute();

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Item removed from the cart!';
    header('location:cart.php');
}

// Clear all items from the cart
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare('DELETE FROM cart');
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'All Items removed from the cart!';
    header('location:cart.php');
}

// Set total price of the product in the cart table
if (isset($_POST['qty'])) {
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $tprice = $qty * $pprice;

    $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
    $stmt->bind_param('isi',$qty,$tprice,$pid);
    $stmt->execute();
}

// Checkout and save customer info in the orders table
if (isset($_POST['action']) && $_POST['action'] == 'order') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $grand_total = $_POST['grand_total'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];

    $data = '';

    $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('sssssss',$name,$email,$phone,$address,$pmode,$products,$grand_total);
    $stmt->execute();
    $stmt2 = $conn->prepare('DELETE FROM cart');
    $stmt2->execute();
    $data .= '<div class="text-center">
                            <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                            <h2 class="text-success">Your Order Placed Successfully!</h2>
                            <h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
                            <h4>Your Name : ' . $name . '</h4>
                            <h4>Your E-mail : ' . $email . '</h4>
                            <h4>Your Phone : ' . $phone . '</h4>
                            <h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
                            <h4>Payment Mode : ' . $pmode . '</h4>
                      </div>';
    echo $data;
}
?>
