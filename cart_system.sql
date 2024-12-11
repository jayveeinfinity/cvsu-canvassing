-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 07:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `canvas_history`
--

CREATE TABLE `canvas_history` (
  `id` int(11) NOT NULL,
  `ref_no` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `submission_deadline` date NOT NULL,
  `delivery_period` date DEFAULT NULL,
  `price_validity` date DEFAULT NULL,
  `approved_budget` decimal(10,2) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `canvas_history`
--

INSERT INTO `canvas_history` (`id`, `ref_no`, `company`, `address`, `tin`, `date`, `submission_deadline`, `delivery_period`, `price_validity`, `approved_budget`, `items`, `grand_total`, `created_at`, `user_id`) VALUES
(20, '123123123', 'COAL ', 'IMUS CITY', '1231233', '2024-12-10', '2024-12-12', '2024-12-18', '2024-12-10', 1000000.00, NULL, 3016.00, '2024-12-01 10:27:53', 728455217),
(21, '12312333', 'yakult', 'dasma', '12323333', '2024-12-30', '2024-12-09', '2024-12-23', '2024-12-16', 23000.00, NULL, 410.00, '2024-12-01 10:47:23', 728455217),
(22, '2342342', 'Burger', 'dasma', '234324', '2024-12-11', '2024-12-12', '2024-12-05', '2024-12-17', 1000000.00, NULL, 79045.00, '2024-12-02 14:54:14', 36293),
(33, '233123', 'banking', 'Richlane', '123233', '2024-12-25', '0000-00-00', '0000-00-00', '0000-00-00', 0.00, NULL, 12140.00, '2024-12-10 13:23:00', 728455217),
(35, '123123', 'new new', 'Richlane', '13123', '2024-12-26', '0000-00-00', '0000-00-00', '0000-00-00', 0.00, NULL, 920.00, '2024-12-10 13:45:00', 728455217),
(36, '354534534', 'bago bago', 'phil', '2221112211', '2024-12-27', '0000-00-00', '0000-00-00', '0000-00-00', 0.00, NULL, 204.00, '2024-12-10 14:00:41', 728455217);

-- --------------------------------------------------------

--
-- Table structure for table `canvas_history_items`
--

CREATE TABLE `canvas_history_items` (
  `id` int(11) NOT NULL,
  `history_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `canvas_history_items`
--

INSERT INTO `canvas_history_items` (`id`, `history_id`, `description`, `qty`, `product_name`, `total_price`, `user_id`) VALUES
(8, 20, 'BALLPEN, black, 0.7mm ', 1, 'pcs', 8.00, 728455217),
(9, 20, 'BALLPEN, blue, 0.7mm', 1, 'pcs', 8.00, 728455217),
(10, 20, 'BATTERY FOR CAMERA\r\n\r\n• Lithium Ion Battery Pack\r\n• Battery Capacity: 860 mAh\r\n• Output Voltage 7.4 VDC\r\n• Color Black ', 1, 'unit', 3000.00, 728455217),
(11, 21, 'Dinner Fork, Japan Stainless', 1, 'pcs', 80.00, 728455217),
(12, 21, 'Dinner Plate, White, Ceramic, 10\"', 1, 'pcs', 250.00, 728455217),
(13, 21, 'Dinner Spoon, Japan Stainless', 1, 'pcs', 80.00, 728455217),
(14, 22, 'Branded Desktop Computer\r\n\r\n• Intel Core i7-12th Gen processor (12\r\ncores 20 threads, 25MB L3 Cache 2.1\r\nGhz Base 4.9 Ghz max frequency 65W\r\nPBP)\r\n• 16GB DDR4 3200mhz UDIMM\r\n• 512 GB M.2 2280 PCI-E SSD + 1TB\r\n3.5 inch 7200 RPM, 2GB of Graphics\r\n(supporting: DVI, HDMI)\r\n• WLAN 802.11 ac/b/g/n wireless LAN\r\nand Bluetooth 4.2 LE\r\n• power supply and adapter 300W\r\n• Keyboard and Mouse USB Keyboard\r\nand wired mouse\r\n• k242hyl, Size: 23.8 monitor\r\n• Windows 11 Bundled Software: MS\r\nOffice Home and Student 2021\r\n(Licensed)\r\n• w/ 1year warranty', 1, 'unit', 70000.00, 36293),
(15, 22, 'Windows 11 Professional Product Key for 1 PC, Lifetime with USB Installer', 1, 'unit', 3000.00, 36293),
(16, 22, 'Yellow Duct Tape (2 inches)', 1, 'pcs', 545.00, 36293),
(17, 22, 'Whiteboard, wall mount, 4 x 8, 2 x 120 x \r\n240cm', 1, 'pcs', 5500.00, 36293),
(78, 35, 'Epson ink, 003, Black ', 1, 'btls', 300.00, 728455217),
(79, 35, 'Epson ink, 003, Cyan', 1, 'btls', 310.00, 728455217),
(80, 35, 'Epson ink, 003, Magenta', 1, 'btls', 310.00, 728455217),
(81, 36, 'SIGN PEN, black, 0.5 ', 1, 'pcs', 68.00, 728455217),
(82, 36, 'SIGN PEN, black, 0.7', 1, 'pcs', 68.00, 728455217),
(83, 36, 'SIGN PEN, black, 1.0 ', 1, 'pcs', 68.00, 728455217);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` varchar(10000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `product_price` varchar(50) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `total_price` varchar(100) NOT NULL,
  `product_code` varchar(10) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_name`, `description`, `product_price`, `product_image`, `qty`, `total_price`, `product_code`, `user_id`) VALUES
(950, 'pcs', 'SIGN PEN, black, 0.5 ', '68', '', 1, '68', '66', 728455217),
(951, 'pcs', 'SIGN PEN, black, 0.7', '68', '', 1, '68', '67', 728455217),
(952, 'pcs', 'SIGN PEN, black, 1.0 ', '68', '', 1, '68', '68', 728455217),
(953, 'unit', 'Windows 11 Professional Product Key for 1 PC, Lifetime with USB Installer', '3000', '', 1, '3000', '31', 42919197),
(954, 'pcs', 'Whiteboard, wall mount, 4 x 8, 2 x 120 x \r\n240cm', '5500', '', 1, '5500', '2', 42919197);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(2, 'electronics'),
(4, 'equipments'),
(1, 'food'),
(3, 'materials'),
(5, 'others'),
(8, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `input_one` text NOT NULL,
  `input_two` text NOT NULL,
  `input_three` text NOT NULL,
  `input_four` text NOT NULL,
  `input_five` text NOT NULL,
  `selected_name` text NOT NULL,
  `selected_role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`input_one`, `input_two`, `input_three`, `input_four`, `input_five`, `selected_name`, `selected_role`) VALUES
('AGASGASDASDSA', '5:00 PM', 'December 14, 2023', '', '', '', ''),
('cavite', '6:00', 'jan 21, 2016', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pmode` varchar(50) NOT NULL,
  `products` varchar(255) NOT NULL,
  `amount_paid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(10000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `product_qty` int(11) NOT NULL DEFAULT 1,
  `product_image` varchar(255) NOT NULL,
  `product_code` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `description`, `product_price`, `product_qty`, `product_image`, `product_code`, `category`) VALUES
(99, 'unit', 'Printer for transparent sticker \r\n• Print Dimension: 200mm*200mm, 210mm*290mm, 210mm*300mm, 297mm*210mm, A4 \r\n• Weight: 34kg \r\n• Ink Type: UV Type \r\n• Dimension (L*W*H): 636*547*490mm \r\n• Color and Page: Multicolor \r\n• Video Outgoing Inspection: Provided \r\n• Software: AcroRIP white ver.9.0 \r\n• Printing Resolution: 1440*1440DPI \r\n• Printing Size: 21*30CM \r\n• Color: CMYK+W+Varnish \r\n• Support System: Windows XP \r\n• Printer Gross Weight: 45kg \r\n', '300000', 5, '', 1, 'electronics'),
(101, 'Unit', 'Desktop i3 \r\n• Windows 11 Home \r\n• Intel Core i3-13th gen \r\n• 8GB DDR4 Memory 1TB HDD, 256GB, M.2 2280 PCI-E SSD Intel UHD 770 Graphics \r\n• MS Office home and student 2021 (licensed) \r\n• 23.8\" screen monitor, 1920x1080 @60Hz \r\n keyboard and mouse \r\n', '40000', 5, '', 12, 'electronics'),
(102, 'bag', 'Tile, 300cm x 300cm ', '60', 1, '', 3, 'materials'),
(103, 'pcs ', 'Tek screw, 12 x 65 Steel - Steel ', '2', 2, '', 4, 'materials'),
(104, 'pcs', '0.80m x 1.20m, Glass Window with complete \r\naccessories', '4200', 7, '', 5, 'materials'),
(106, 'unit', 'DSLR CAMERA\r\n\r\n• 18-55mm VT Lens Kit\r\n• Approx. 124 x 97 x 70(4.9x3.9x2.8in)\r\n• 24.2 Megapixel\r\n• 5 FPS Continuous Shooting\r\n• 23.5 mm 15.6mm Image Sensor Size\r\n• 3.2 LCD Monitor\r\n• Built-in Wifi ', '50000', 2, '', 6, 'electronics'),
(107, 'unit', 'BATTERY FOR CAMERA\r\n\r\n• Lithium Ion Battery Pack\r\n• Battery Capacity: 860 mAh\r\n• Output Voltage 7.4 VDC\r\n• Color Black ', '3000', 2, '', 7, 'electronics'),
(108, 'unit', 'Branded Desktop Computer\r\n\r\n• Intel Core i7-12th Gen processor (12\r\ncores 20 threads, 25MB L3 Cache 2.1\r\nGhz Base 4.9 Ghz max frequency 65W\r\nPBP)\r\n• 16GB DDR4 3200mhz UDIMM\r\n• 512 GB M.2 2280 PCI-E SSD + 1TB\r\n3.5 inch 7200 RPM, 2GB of Graphics\r\n(supporting: DVI, HDMI)\r\n• WLAN 802.11 ac/b/g/n wireless LAN\r\nand Bluetooth 4.2 LE\r\n• power supply and adapter 300W\r\n• Keyboard and Mouse USB Keyboard\r\nand wired mouse\r\n• k242hyl, Size: 23.8 monitor\r\n• Windows 11 Bundled Software: MS\r\nOffice Home and Student 2021\r\n(Licensed)\r\n• w/ 1year warranty', '70000', 2, '', 8, 'electronics'),
(109, 'unit', 'LAPTOP\r\n• Intel Core i7 12th Gen processor (24MB\r\nSmart Cache, 2.3GHz Performance-core\r\nwith Intel Turbo Boost Max Technology up\r\nto 4.7GHz)\r\n• NVIDIA GeForce RTX3050 1500-1740\r\nMHz Boost Clock NVIDIA Ampere\r\nStreaming Multiprocessors\r\n• 8GB of DDR4 system memory 3200MHz\r\n- 512GB NVMe SSD (HDD Upgrade Kit\r\nIncluded)\r\n• 15.6” display with IPS (In-Plane\r\nSwitching) technology, Full HD 1920 x\r\n1080, high-brightness (300nits) LED-backlit\r\nTFT LCD, supporting 144 Hz and 3 ms\r\nOverdrive\r\n• Windows 11 Home\r\n• Killer Wi-Fi 6 AX1650i Bluetooth 5.1\r\n• 57.5Wh 4-cell Li-Ion battery\r\n• Microsoft Office Home and Student 2021\r\n(Licensed) ', '70000', 1, '', 9, 'electronics'),
(110, 'unit', 'External Hard Drive, 2TB, 2.5\" ', '3850', 2, '', 10, 'electronics'),
(113, 'pcs', 'Whiteboard, wall mount, 4 x 8, 2 x 120 x \r\n240cm', '5500', 1, '', 2, 'materials'),
(114, 'pcs', 'Chair, monobloc, without armrest', '700', 41, '', 14, 'materials'),
(130, 'roll', 'ACETATE, gauge #2.6, 50m per roll (plastic \r\ncover)', '740', 12, '', 15, 'materials'),
(131, 'pcs', 'ACRYLIC TABLE SIGNAGE, 16in x 4in', '2000', 1, '', 16, 'materials'),
(132, 'pcs', 'BALLPEN, black, 0.7mm ', '8', 600, '', 17, 'materials'),
(133, 'pcs', 'BALLPEN, blue, 0.7mm', '8', 100, '', 18, 'materials'),
(135, 'pcs', 'BROWN ENVELOPE, A4', '3', 100, '', 19, 'materials'),
(136, 'pcs', 'BROWN ENVELOPE, Long ', '3', 100, '', 20, 'materials'),
(137, 'pcs', 'CABLE, HDMI, 3m ', '300', 12, '', 21, 'materials'),
(147, 'sets', 'Jersey and Short, Sublimation', '800', 1, '', 11, 'equipments'),
(148, 'sets', 'Jersey Shirt and Short, Sublimation', '800', 1, '', 13, 'equipments'),
(149, 'pcs', 'Jersey shirt only', '500', 1, '', 23, 'equipments'),
(150, 'pcs', 'Collared jersey shirt only', '500', 1, '', 24, 'equipments'),
(151, 'unit', 'Laptop \r\n\r\n• Processor: Intel Core i7 13th Gen\r\n(30 MB Smart Cache, 2.1 GHz\r\nPerformance-core with Intel Turbo\r\nBoost Max Technology 3.0 up to 5.0\r\nGHz\r\n• Memory: 16GB of DDR5 4800MHz\r\n• Storage: 512GB NVMe SSD\r\n• Graphics: RTX 4060 8GB DDR6 VRAM\r\n• Display: 16” Display with IPS (InPlane Switching) technology, WQXGA 2560 x 1600\r\n• Webcam: 1920 x 1080 resolution,\r\n1080p HD video at 60 fps with\r\nTemporal Noise Reduction with Dual\r\nMic\r\n• Connectivity: Wi-Fi 6, Bluetooth 5.2,\r\nEthernet (RJ-45) port\r\n• Audio: DTS X Ultra Audio\r\n• Keyboard: 99-/100-/-103-key with\r\nindependent standard numeric keypad\r\nand international language support\r\n• Software: Windows 11 Home 64bit\r\n(Licensed) with MS Office Home and\r\nStudent 2021 (Licensed)\r\n• Warranty: 2 Years\r\n• Free: Bag and Chair', '90000', 1, '', 25, 'electronics'),
(152, 'btls', 'Epson ink, 003, Black ', '300', 1, '', 26, 'electronics'),
(153, 'btls', 'Epson ink, 003, Yellow', '310', 1, '', 27, 'electronics'),
(154, 'btls', 'Epson ink, 003, Magenta', '310', 1, '', 28, 'electronics'),
(155, 'btls', 'Epson ink, 003, Cyan', '310', 1, '', 29, 'electronics'),
(156, 'pcs', 'Hard drive, 11 x 13 x 8cm, 948.01 grams, 3TB', '6000', 1, '', 30, 'electronics'),
(157, 'unit', 'Windows 11 Professional Product Key for 1 PC, Lifetime with USB Installer', '3000', 1, '', 31, 'electronics'),
(158, 'unit', 'Adobe Software – Desktop software for\r\nPhoto, video, 3d etc. with creative cloud\r\nstorage and access to over 20 desktop\r\nediting applications; good for 1 PC', '1666', 1, '', 32, 'electronics'),
(159, 'months', 'Microsoft Office 365 Professional Plus\r\nfor 15 Devices, Lifetime', '3000', 1, '', 34, 'electronics'),
(160, 'unit', 'Laptop\r\n• Intel Core i7 12th Gen processor (24MB\r\nSmart Cache, 2.3GHz Performance-core\r\nwith Intel Turbo Boost Max Technology up\r\nto 4.7GHz)\r\n• NVIDIA GeForce RTX3050 1500-1740\r\nMHz Boost Clock NVIDIA Ampere\r\nStreaming Multiprocessors\r\n• 8GB of DDR4 system memory 3200MHz\r\n• 512GB NVMe SSD (HDD Upgrade Kit\r\nIncluded)\r\n• 15.6” display with IPS (In-Plane\r\nSwitching) technology, Full HD 1920 x\r\n1080, high-brightness (300nits) LED-backlit\r\nTFT LCD, supporting 144 Hz and 3 ms\r\nOverdrive\r\n• Windows 11 Home\r\n• Killer Wi-Fi 6 AX1650i Bluetooth 5.1\r\n• 57.5Wh 4-cell Li-Ion battery\r\n• Microsoft Office Home and Student 2021\r\n(Licensed) \r\n', '70000', 1, '', 33, 'electronics'),
(161, 'unit', 'DESKTOP COMPUTER\r\n• Intel Core i7-13700 processor (16-Core,\r\n24MB Cache, 2.1GHz to 5.1GHz)\r\n• 16GB, 1 x 16 GB, DDR4, 3200 MHz\r\n• 512GB, M.2, PCIe NVMe, SSD\r\n• Intel UHD Graphics 770 with shared\r\ngraphics memory\r\n• Wi-Fi 6 RTL8852BE, 2x2, 802.11ax, MUMIMO, Bluetooth wireless card\r\n• 24-inch FHD monitor\r\n• Windows 11 Home (Licensed)\r\n• Microsoft Office Home and Student 2021\r\n(Licensed)\r\n• Wired Keyboard and Optical Mouse\r\n• 12months warranty \r\n', '55000', 1, '', 35, 'electronics'),
(162, 'unit', 'Multi-function WiFi printer\r\n- Print, Scan, Copy\r\n- ESC/P-R, ESC/P Raster Printer\r\nLanguage\r\n- 5760x1440 dpi maximum resolution\r\n- up to 33.0 ppm / 15.0 ppmx2 (Draft,A4)\r\n- ISO 29183, A4 Simplex copying (up to\r\n7.7 ipm / 3.8 ipm)\r\n- A4, Letter Maximum Copy Size\r\n- Flatbed colour image scanner Scanner\r\nType\r\n- 216x297mm scan area\r\n- CIS Sensor Type\r\n- 375x347x179mm dimensions (WxDxH)', '15000', 1, '', 36, 'electronics'),
(163, 'pcs', 'External Hard Drive, 2TB, 2.5\"', '3850', 1, '', 37, 'electronics'),
(164, 'pcs', 'External Hard Drive, 4TB, 2.5\"', '9380', 1, '', 38, 'electronics'),
(165, 'unit', 'Desktop i3\r\n• Windows 11 Home\r\n• Intel Core i3-13th gen\r\n• 8GB DDR4 Memory\r\n• 1TB HDD, 256GB, M.2 2280 PCI-E SSD\r\n• Intel UHD 770 Graphics\r\n• MS Office home and student 2021\r\n(licensed)\r\n• 23.8\" screen monitor, 1920x1080 @60Hz\r\n• keyboard and mouse', '40000', 1, '', 39, 'electronics'),
(166, 'bundle', 'Google Cloud Storage\r\n• 2TB for 3 years\r\n• Access to google experts\r\n• Share with up to 5 others\r\n• More google photos editing features\r\n• Google workspace premium features\r\n• Monitor the dark web', '15000', 1, '', 40, 'electronics'),
(167, 'unit', 'Printer for transparent sticker\r\n• Print Dimension: 200mm*200mm,\r\n210mm*290mm, 210mm*300mm,\r\n297mm*210mm, A4\r\n• Weight: 34kg\r\n• Ink Type: UV Type\r\n• Dimension (L*W*H): 636*547*490mm\r\n• Color and Page: Multicolor\r\n• Video Outgoing Inspection: Provided\r\n• Software: AcroRIP white ver.9.0\r\n• Printing Resolution: 1440*1440DPI\r\n• Printing Size: 21*30CM\r\n• Color: CMYK+W+Varnish\r\n• Support System: Windows XP\r\n• Printer Gross Weight: 45kg \r\n', '30000', 1, '', 41, 'electronics'),
(168, 'sets', 'DSLR Camera\r\n• 18-55mm VT Lens Kit\r\n• Approx. 124 x 97 x 70(4.9x3.9x2.8in)\r\n• 24.2 Megapixel\r\n• 5 FPS Continuous Shooting\r\n• 23.5 mm 15.6mm Image Sensor Size\r\n• 3.2 LCD Monitor\r\n• Built-in Wifi ', '50000', 1, '', 42, 'electronics'),
(169, 'pcs', 'Battery for Camera\r\n• Lithium Ion Battery Pack\r\n• Battery Capacity: 860 mAh\r\n• Output Voltage 7.4 VDC\r\n• Color Black', '3000', 1, '', 43, 'electronics'),
(170, 'pcs', 'Coco Lumber 2”x 2” x 8’', '135', 1, '', 44, 'materials'),
(171, 'pcs', 'Sand Paper', '55', 1, '', 45, 'materials'),
(172, 'pcs', 'Mop Dust Floor Mop 59 inches', '2200', 1, '', 46, 'materials'),
(173, 'pcs', 'Yellow Duct Tape (2 inches)', '545', 1, '', 47, 'materials'),
(174, 'pcs', 'Coffee Cups, 8oz, Ceramic White', '150', 1, '', 48, 'materials'),
(175, 'pcs', 'Dinner Plate, White, Ceramic, 10\"', '250', 1, '', 49, 'materials'),
(176, 'pcs', 'Dinner Spoon, Japan Stainless', '80', 1, '', 50, 'materials'),
(177, 'pcs', 'Dinner Fork, Japan Stainless', '80', 1, '', 51, 'materials'),
(178, 'pcs', 'Juice Dispenser Acrylic with Stainless Stand, 8L\r\nCapacity', '7500', 1, '', 52, 'materials'),
(179, 'pcs', 'INK CART, EPSON C13T664100 (T6641), Black', '249', 1, '', 53, 'electronics'),
(180, 'pcs', 'INK CART, EPSON C13T664200 (T6642), Cyan', '249', 1, '', 54, 'electronics'),
(181, 'pcs', 'INK CART, EPSON C13T664300 (T6643),\r\nMagenta', '249', 1, '', 55, 'electronics'),
(182, 'pcs', 'INK CART, EPSON C13T664400 (T6644),\r\nYellow', '249', 1, '', 56, 'electronics'),
(187, 'pcs', 'BATTERY, AAA, 2\'s, HD ', '77', 1, '', 61, 'materials'),
(188, 'pcs', 'CABLE VGA 3m', '550', 1, '', 62, 'materials'),
(189, 'pcs', 'DVI to VGA Converter', '520', 1, '', 63, 'materials'),
(192, 'pcs', 'SIGN PEN, black, 0.5 ', '68', 1, '', 66, 'materials'),
(193, 'pcs', 'SIGN PEN, black, 0.7', '68', 1, '', 67, 'materials'),
(194, 'pcs', 'SIGN PEN, black, 1.0 ', '68', 1, '', 68, 'materials'),
(195, 'pcs', 'SIGN PEN, blue, 0.5', '68', 1, '', 69, 'materials'),
(196, 'pcs', 'SIGN PEN, blue, 0.7', '68', 1, '', 70, 'materials'),
(197, 'pcs', 'SIGN PEN, blue, 1.0', '68', 1, '', 71, 'materials'),
(198, 'pcs', 'SIGN PEN, red, 0.5 ', '68', 1, '', 72, 'materials'),
(211, 'box', 'gunting', '', 1, '', 9999999, 'equipments');

-- --------------------------------------------------------

--
-- Table structure for table `send_to_supply`
--

CREATE TABLE `send_to_supply` (
  `id` int(11) NOT NULL,
  `canvas_history_id` int(11) NOT NULL,
  `supplier_id` bigint(11) NOT NULL,
  `sent_date` datetime DEFAULT current_timestamp(),
  `remarks` text DEFAULT NULL,
  `canvasser_user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `send_to_supply`
--

INSERT INTO `send_to_supply` (`id`, `canvas_history_id`, `supplier_id`, `sent_date`, `remarks`, `canvasser_user_id`) VALUES
(1, 21, 42919197, '2024-12-09 23:12:23', NULL, 0),
(2, 20, 42919197, '2024-12-10 00:23:20', NULL, 0),
(8, 35, 42919197, '2024-12-10 21:45:08', NULL, 0),
(15, 36, 42919197, '2024-12-10 22:16:58', NULL, 728455217);

-- --------------------------------------------------------

--
-- Table structure for table `signatories`
--

CREATE TABLE `signatories` (
  `id` int(11) NOT NULL,
  `signatoryName` varchar(50) NOT NULL,
  `signatoryRole` varchar(255) NOT NULL,
  `signatoryImage` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signatories`
--

INSERT INTO `signatories` (`id`, `signatoryName`, `signatoryRole`, `signatoryImage`) VALUES
(7, 'John Rafael Balaba', 'BAC Secretary, Goods and Consulting Services', '65b651efcb2c7.png');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`) VALUES
(10, 'box'),
(7, 'btls'),
(11, 'bundle'),
(9, 'cart'),
(5, 'gallon'),
(3, 'liters'),
(8, 'months'),
(1, 'pcs'),
(6, 'roll'),
(4, 'sets'),
(2, 'unit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(100) NOT NULL DEFAULT 'canvasser',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_approved` tinyint(1) DEFAULT 0,
  `Full_name` varchar(100) NOT NULL,
  `Phone_number` int(13) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `profile_image` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `password`, `usertype`, `date`, `is_approved`, `Full_name`, `Phone_number`, `Department`, `profile_image`) VALUES
(8, 1, 'admin@gmail.com', '$2y$10$Eyn2C6ZlkOor9go5mEffsuKwamPa/m5rL.YWt48Jfz6Yr/V7EJTA6', 'admin', '2024-12-01 14:31:24', 1, '', 0, '', ''),
(43, 8864489, 'janjanbalaba747@gmail.com', '123', 'supplier', '2024-12-04 15:15:18', 1, '', 0, '', ''),
(45, 728455217, 'angelolagmay20@gmail.com', '$2y$10$hChX9lk5tFQc.16Gwt5MrOCpoB0knISh6JjbS.Cn9.Ot9qjlOZRlq', 'canvasser', '2024-12-05 17:31:14', 1, 'angelo lagmay', 2147483647, 'BSIT', '1733072211_zoro1.jpg'),
(50, 36293, 'juandelacruz@gmail.com', '$2y$10$jlspitTGD7e55d3Qeb9KG.IQtauqtszWj5dr9KaxQOjTp3oDZIsUi', 'canvasser', '2024-12-01 16:00:58', 1, 'Juan Dela Cruz', 2147483647, 'BSCS', ''),
(53, 551771842, 'test@gmail.com', '$2y$10$Yn6xx1FB0zdYHm5/n/uBGexC/NmY/lbWJtcu0c6yJ5JJJrGxSXyYG', 'canvasser', '2024-12-01 15:26:15', 1, 'test ', 2147483647, 'BSIT', ''),
(56, 42919197, 'geoman@gmail.com', '$2y$10$QVbZAXe0PWdkzAwCCAfEjuKGhbvyIE/i9O9G.pw2yNzCc.0q8XD5a', 'supplier', '2024-12-01 15:26:13', 1, 'geoman', 2147483647, 'BSIT', ''),
(58, 45083, 'janjanbalaba123@gmail.com', '$2y$10$puYXDvxOy2lOhVTNUD20dek9vr36LmT5mRljBfIoIDKBPGanbxu2G', 'supplier', '2024-12-09 18:28:41', 1, 'janjan', 2147483647, 'BSCS', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canvas_history`
--
ALTER TABLE `canvas_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `canvas_history_items`
--
ALTER TABLE `canvas_history_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_id` (`history_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_to_supply`
--
ALTER TABLE `send_to_supply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `canvas_history_id` (`canvas_history_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `signatories`
--
ALTER TABLE `signatories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unit_name` (`unit_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `canvas_history`
--
ALTER TABLE `canvas_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `canvas_history_items`
--
ALTER TABLE `canvas_history_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=955;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `send_to_supply`
--
ALTER TABLE `send_to_supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `signatories`
--
ALTER TABLE `signatories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `canvas_history`
--
ALTER TABLE `canvas_history`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `canvas_history_items`
--
ALTER TABLE `canvas_history_items`
  ADD CONSTRAINT `canvas_history_items_ibfk_1` FOREIGN KEY (`history_id`) REFERENCES `canvas_history` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `send_to_supply`
--
ALTER TABLE `send_to_supply`
  ADD CONSTRAINT `send_to_supply_ibfk_1` FOREIGN KEY (`canvas_history_id`) REFERENCES `canvas_history` (`id`),
  ADD CONSTRAINT `send_to_supply_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
