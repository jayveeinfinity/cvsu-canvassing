<?php
header('Content-Type: application/pdf');

require_once('tcpdf/tcpdf.php');
include("config.php");

$products = [
    ['id' =>  35, 'qty' =>  10, 'unitPrice' =>  96000], ['id' =>  25, 'qty' =>  5, 'unitPrice' =>  5100]
];

// Step 2: Validate data
function searchValue($array, $key, $value) {
    foreach ($array as $item) {
        if (is_array($item) && isset($item[$key]) && $item[$key] == $value) {
            return $item;
        }
    }
    return null;
}

$data = json_decode(file_get_contents('php://input'), true);
$inputOne = $data['input_one'];
$inputTwo = $data['input_two'];
$inputThree = $data['input_three'];
$inputFour = $data['input_four'];
$inputFive = $data['input_five'];
$products = $data['products'];
$filename = $data['filename'];

if (!isset($data['input_one'], $data['input_two'], $data['input_three'] , $data['input_four'] , $data['input_five'])) {
    die('Invalid or missing input data.');
}

// Step 3: Fetch data from the database
$query = "SELECT * FROM cart";
$result = mysqli_query($conn, $query);

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

// Calculate grand total
$grand_total = array_reduce($rows, function ($sum, $row) {
    return $sum + $row['total_price'];
}, 0);


// Step 4: Extend TCPDF class for custom header/footer
class MYPDF extends TCPDF {
    public function Header() {
        // Custom header content
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'C');
    }
}

// Step 5: Create PDF
$pdf = new MYPDF();

// Set margins (unchanged)
$pdf->SetMargins(25, 20, 15);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

// Position content higher within the current margins
$pdf->SetY(15); // Adjust this value to position content within the current margin limits

// Add the image, positioned higher
$pdf->Image(__DIR__ . '/assets/img/cvsu.png', 40, 13, 30, 0); // Align the image's Y position with text

// Add main text, positioned higher
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C'); // Reduced height for spacing
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 5, 'CAVITE STATE UNIVERSITY', 0, 1, 'C');
$pdf->Cell(0, 5, 'Don Severino de las Alas Campus', 0, 1, 'C');
$pdf->Cell(0, 5, 'Indang, Cavite, Philippines', 0, 1, 'C');
$pdf->Cell(0, 5, '(046) 889-6373 | www.cvsu.edu.ph', 0, 1, 'C');





// Section: Invitation to Submit Quotation
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'INVITATION TO SUBMIT QUOTATION', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->Ln(5);

// Display input values below the title
$pdf->SetFont('helvetica', '', 11); // Set font size to 11
$pdf->Cell(0, 10, 'Date: ' . htmlspecialchars($inputThree), 0, 1, 'R');
$pdf->Cell(0, 10, 'Ref No. ' . htmlspecialchars($inputOne), 0, 1, 'R');
$pdf->Cell(0, 10, 'Company: ' . htmlspecialchars($inputTwo), 0, 1, 'L');
$pdf->Cell(0, 10, 'Address: ' . htmlspecialchars($inputFour), 0, 1, 'L');
$pdf->Cell(0, 10, 'TIN: ' . htmlspecialchars($inputFive), 0, 1, 'L');
$pdf->Cell(0, 10, 'Sir/Madam:  ', 0, 1, 'L');
$pdf->Cell(0, 5, '      Please quote your lowest price on the item/s listed below, subject to the Terms and Conditions', 0, 1, 'L');
$pdf->Cell(0, 5, 'on the last page, stating the shortest time of delivery. Submit your quotation duly signed by your', 0, 1, 'L');
$pdf->Cell(0, 5, 'authorized representative not later than ______', 0, 1, 'L');
$pdf->SetFont('helvetica', 'B', 11); // Set font to bold (B)
$pdf->Cell(0, 10, 'NOTE:  ', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 11); // Set font to bold (B)

// Add a line break
$pdf->Ln(2);




$htmlContent = <<<EOD
<ol style="font-size: 11px; margin-top: 20px; text-align: justify; padding-left: 20px;">
    <li style="margin-top: 10px;">All entries must be written legibly or typewritten.</li>
    <li style="margin-top: 10px;">Delivery Period: _____ calendar days from receipt of P.O.</li>
    <li style="margin-top: 10px;">Warranty shall be for a period of six (6) months for supplies and materials. Warranty for equipment must not be less than one (1) year from date of acceptance, accompanied by Warranty Certificate.
    </li>
    <li style="margin-top: 10px;">Price validity shall be for a period of _____ <b>calendar days.</b></li>
    <li style="margin-top: 10px;">Bidders shall indicate the brand and model of the items being offered.</li>
    <li style="margin-top: 10px;"><b>Approved Budget for the Contract (ABC): P __________</b></li>
</ol>
EOD;



// Write HTML content to the PDF
$pdf->writeHTML($htmlContent, true, false, true, false, '');

// Table of Items
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 10);
$tableHeader = <<<EOD
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
        <th style="width: 35px;"><b>Item No.</b></th>
        <th style="width: 55px;"><b>Quantity</b></th>
        <th style="width: 45px;"><b>Unit</b></th>
        <th style="width: 180px;"><b>Description</b></th>
        <th><b>Unit Cost</b></th>
        <th><b>Total Cost</b></th>
        </tr>
    </thead>
    <tbody>
EOD;

$tableBody = '';
foreach ($rows as $key => $row) {
    $item = searchValue($products, 'id', $row['product_code']);
    $unitPrice = $item ? (!is_null($item['unitPrice']) ? $item['unitPrice'] : 0)  : 0;
    $tableBody .= '<tr>
        <td style="width: 35px;">' . ($key + 1) . '</td>
        <td style="width: 55px;">' . htmlspecialchars($row['qty']) . '</td>
        <td style="width: 45px;">' . htmlspecialchars($row['product_name']) . '</td>
        <td style="width: 180px;">' . nl2br(htmlspecialchars($row['description'])) . '</td>
        <td>' . number_format($unitPrice, 2) . '</td>
        <td>' . number_format(($unitPrice * $row['qty']), 2) . '</td>
    </tr>';
}


$tableFooter = <<<EOD
    </tbody>
</table>
EOD;

$pdf->writeHTML($tableHeader . $tableBody . $tableFooter, true, false, true, false, '');


// Set font to normal (non-bold)
$pdf->SetFont('helvetica', '', 10);  // You can adjust the font size as needed

// Additional HTML content after the table
$newHtmlContent = <<<EOD
<p style="text-align: justify; font-size: 11px; margin-top: 20px; text-indent: 30px;">
After having carefully read and accepted your <b>Terms and Conditions</b>, I quote you on the item/s at the price noted above.
</p>

<p style="text-align: right; font-size: 11px;">
    _____________________________
</p>
<p style="text-align: right; font-size: 11px;">
    Printed Name/Signature
</p>

<p style="text-align: right; font-size: 11px;">
    _____________________________
</p>
<p style="text-align: right; font-size: 11px;">
    Tel No./Email Address
</p>

<p style="text-align: right; font-size: 11px;">
    _____________________________
</p>
<p style="text-align: right; font-size: 11px;">
    Date
</p>

<p style="text-align: justify; font-size: 11px;">
    Canvassed by:
</p>

<p style="text-align: justify; font-size: 11px;">
    __________________________________________
</p>

<p style="text-align: justify; font-size: 11px;">
    Signature over Printed Name
</p>
EOD;

// Write the additional HTML content
$pdf->writeHTML($newHtmlContent, true, false, true, false, '');




// Output PDF
$pdf->Output('Invitation_to_Quote.pdf', 'I');
?>
