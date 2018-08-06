<?php
require 'fpdf.php';
include 'data/products.php';

$request = json_decode($_GET['products']);
$products = array();
foreach ($request as $product_id => $value) {
    foreach ($productDB as $productRow) {
        if ($productRow['id'] == $product_id) {
            $productRow['quantity'] = $value;
            array_push($products, $productRow);
            break;
        }
    }
}
$left = 30;
$right = 30;
$width = 210;

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->SetMargins($left, 0);

$pdf->AddFont('Avenir', '', 'AvenirNextLTPro-Regular.php');
$pdf->AddFont('Avenir', 'B', 'AvenirNextLTPro-Demi.php');
$pdf->SetFont("Avenir", "B", 12);

// header image
$pdf->Image('images/header.png', $left, 20, $width - $left - $right);
$pdf->Ln();

// filling the header and setting the label
$pdf->SetFillColor(246, 88, 39);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetY(70);
$pdf->Cell(0, 41, "", 0, 1, 'c', true);
$pdf->SetY(75);
// $pdf->Cell(0,6,"PREFERRED FREQUENCY TO ",0,1,'C',false);
// $pdf->Cell(0,6,"RECEIVE THESE ITEMS",0,1,'C',false);
$pdf->Cell(0, 6, "Items Selected", 0, 1, 'C', false);

// table head
$pdf->SetFillColor(217, 75, 31);
$pdf->Cell(0, 6, '', 0, 1, 'C', false); // spacing for table head
$pdf->Cell(0, 18, '', 0, 1, 'C', true); // table head background

$y = $pdf->GetY() - 18;
$pdf->SetY($y);
$pdf->SetX($left + 5);
$pdf->SetFont('Avenir', '', 8);
$pdf->Cell(65, 10, "Products", 0, 0, "C", true);
$pdf->Cell(25, 10, "Usual Price", 0, 0, "C", true);
$pdf->Cell(25, 10, "Quantity", 0, 0, "C", true);
$pdf->Cell(25, 10, "Total", 0, 1, "C", true);

// Drawing the damn box
$y = $pdf->GetY();
$spacing = 0;
foreach ($products as $row) {
    $lines = ceil(strlen($row['title']) / 43);
    $spacing += 13;
    for ($i = 1; $i < $lines; $i++) {
        $spacing += 8;
    }
}
//$spacing = count($products) * 13; // spacing for products
$spacing += 80; // spacing for summary

$pdf->SetY($y);
$pdf->SetFillColor(246, 88, 39);
$pdf->Cell(0, $spacing, "", 0, 1, 'C', true);
$pdf->SetY($y + 2);

// ADDING PRODUCTS
$total_products = 0;
$total_price = 0;

$left_pad = 5 + $left;
$right_pad = 5;
foreach ($products as $product) {
    $cellHeight = 10 + ((ceil(strlen($product['title']) / 43) - 1) * 5);

    $total_products += $product['quantity'];
    $product_name = $product['title'] . "\n" . '(' . $product['subtitle'] . ")";
    $product_subtitle = $product['subtitle'];
    $price = "      $ " . number_format($product['price'], 2);

    $quantity = $product['quantity'];
    $total = "$ " . number_format(($product['quantity'] * $product['price']), 2);
    $total_price += ($product['quantity'] * $product['price']);

    $y = $pdf->GetY();

    $pdf->SetDrawColor(246, 88, 39);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont("Avenir", "B", 8);
    $pdf->SetFillColor(244, 125, 88);
    $pdf->SetX($left_pad);
    $pdf->MultiCell(64, 5, $product_name, "", "L", true);
    $nextY = $pdf->GetY();

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetY($y);
    $pdf->SetX(100);

    $pdf->SetFont("Avenir", "B", 10);
    $pdf->Cell(30, $cellHeight, $price, "", 0, "L", true);
    $pdf->Cell(20, $cellHeight, $quantity, "", 0, "C", true);
    $pdf->Cell(25, $cellHeight, $total, "", 1, "C", true);
    $pdf->Cell(130, 0.3, '', "", 1, "C", false);
}

// Subscription plan result

// drawing the box
$y = $pdf->GetY();
$y += 5;
$pdf->SetY($y);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetX($left_pad);
$pdf->Cell(140, 70, "", "B", 0, 0, "C", true);

$pdf->SetY($y);

// setting the values

$pdf->SetTextColor(246, 88, 39);

$pdf->SetFont("Avenir", "B", 12);
$pdf->Cell(0, 20, "SUBSCRIPTION PLAN SUMMARY", 0, 1, "C");

$pdf->SetFont("Avenir", "", 8);
$pdf->SetFillColor(246, 88, 39);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetX($left_pad + 10);
$pdf->SetDrawColor(255, 255, 255);
$pdf->Cell(60, 10, "TOTAL NO. OF ITEMS", "B", 0, "C", true);
$pdf->Cell(60, 10, "TOTAL PRICE", "B", 1, "C", true);

$pdf->SetFillColor(251, 251, 251);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX($left_pad + 10);

$pdf->SetFont("Avenir", "B", 14);
$pdf->Cell(59, 14, $total_products, "T", 0, "C", true);
$pdf->Cell(2, 10, "", "T", 0, "C", false);
$pdf->Cell(59, 14, "$ " . $total_price, "T", 0, "C", true);

$pdf->SetTextColor(246, 88, 39);

$pdf->SetFont("Avenir", "", 10);
$pdf->SetY($pdf->GetY() + 25);
$pdf->Cell(0, 4, "YOU HAVE OPTED TO RECEIVE THESE ITEMS", 0, 1, "C");
$pdf->Cell(0, 4, "ONCE EVERY " . $_GET['receive'] . " MONTH", 0, 1, "C");
if ($total_price < 140) {
    $pdf->Cell(0, 4, "THIS ORDER HAS NOT REACHED THE MINIMUM SPEND OF $140", 0, 1, "C");
}

// smart shopper scheme
$pdf->AddPage();
$y = $pdf->GetY();
$pdf->SetY($y + 16);

$pdf->SetFont("Avenir", "B", 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(44, 61, 122);

$pdf->Cell(120, 15, "With Smart Shopper Scheme ", 0, 0, "C", true);
$pdf->Cell(30, 15, "You Pay", 0, 1, "L", true);

if ($total_price < 140) {
    $y = $pdf->GetY();

    $pdf->SetFont("Avenir", "B", 8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(256, 256, 256);

    $pdf->Cell(0, 4, "This order has not reached the minimum spend of $140.", 0, 1, "C");
}

// start of the orders
$order_height = 11;
$padding_top = 0.5;
$padding_bottom = 0.5;
$padding = $order_height + $padding_top + $padding_bottom;
$box_height = 150;

$y = $pdf->GetY();
$pdf->SetFillColor(244, 245, 249);
$pdf->Cell(0, $box_height, "", 0, 1, "C", true);
$pdf->SetY($y);

$discounts = array(
    0, 11, 18, 18, 25, 25, 25, 25, 25, 25, 25, 25, 25,
);

$cummulative_price = $total_price;
$total_savings = 0;

$top_cell_padding = 1;
$top_cell_height = 6;
$bottom_cell_height = 5;
for ($i = 1; $i <= 12; $i++) {
    $savings = $cummulative_price * ($discounts[$i] / 100);
    $cummulative_price = $total_price - $savings;
    $savings = sprintf("%.2f", $savings);
    $cummulative_price = sprintf("%.2f", $cummulative_price);
    $total_savings += $savings;

    $pdf->SetFont("Avenir", "", 12);
    $y = $pdf->GetY();
    $pdf->SetY($y + $padding_top);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(55, 79, 161);
    $pdf->Cell(50, $order_height, "ORDER " . $i, 0, 0, "C", true);
    $pdf->Cell(1, $order_height, "", 0, 0, "C", false);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->Cell(50, $top_cell_padding, "", 0, 0, "", true);
    $pdf->Cell(1, $top_cell_padding, "", 0, 0, "C", false);
    $pdf->Cell(50, $top_cell_padding, "", 0, 1, "", true);

    $pdf->SetY($y + $top_cell_padding);
    $pdf->SetFont("Avenir", "B", 12);
    if ($total_price >= 140) {
        $pdf->Cell(51, $top_cell_height, "", 0, 0, "L", false);
        $pdf->Cell(50, $top_cell_height, "     Save $ " . number_format($savings, 2), 0, 0, "L", true);
        $pdf->Cell(1, $top_cell_height, "", 0, 0, "C", false);
        $pdf->Cell(50, $top_cell_height, "     $" . number_format($cummulative_price, 2), 0, 1, "L", true);
    } else {
        $pdf->Cell(51, $top_cell_height, "", 0, 0, "L", false);
        $pdf->Cell(50, $top_cell_height, "", 0, 0, "L", true);
        $pdf->Cell(1, $top_cell_height, "", 0, 0, "C", false);
        $pdf->Cell(50, $top_cell_height, "", 0, 1, "L", true);
    }

    if($total_price >= 140){
        $pdf->SetY($y + $top_cell_height);
        $pdf->SetFont("Avenir", "", 8);
        $pdf->Cell(51, $bottom_cell_height, "", 0, 0, "L", false);

        if ($i == 1) {
            $pdf->Cell(50, $bottom_cell_height, "       " . $discounts[$i] . "% Rebate on first order", 0, 0, "L", true);
        } else {
            $pdf->Cell(50, $bottom_cell_height, "       " . $discounts[$i] . "% Rebate on previous order", 0, 0, "L", true);
        }
        $pdf->Cell(1, $bottom_cell_height, "", 0, 0, "C", false);
        $pdf->Cell(50, $bottom_cell_height, "        before $ " . number_format($total_price, 2), 0, 1, "L", true);
    } else {
        $pdf->SetY($y + $top_cell_height);
        $pdf->SetFont("Avenir", "", 9);
        $pdf->Cell(51, $bottom_cell_height, "", 0, 0, "L", false);
        
        if ($i == 1) {
            $pdf->Cell(50, $bottom_cell_height,  $discounts[$i] . "% Rebate on first order", 0, 0, "L", true);
        } else {
            $pdf->Cell(50, $bottom_cell_height,  $discounts[$i] . "% Rebate on previous order", 0, 0, "L", true);
        }
        $pdf->Cell(1, $bottom_cell_height, "", 0, 0, "C", false);
        $pdf->Cell(50, $bottom_cell_height, "", 0, 1, "L", true);
    }
    

    $y = $pdf->GetY();
    $pdf->SetY($y + $padding_bottom);

}

// summary

$pdf->SetFont("Avenir", "", 12);
$y = $pdf->GetY();
$pdf->SetY($y + $padding_top);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(55, 79, 161);
$pdf->Cell(50, $order_height, "TOTAL", 0, 0, "C", true);
$pdf->Cell(1, $order_height, "", 0, 0, "C", false);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFillColor(240, 89, 32);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, $top_cell_padding, "", 0, 0, "", true);
$pdf->Cell(1, $top_cell_padding, "", 0, 0, "C", true);
$pdf->Cell(50, $top_cell_padding, "", 0, 1, "", true);

$pdf->SetY($y + $top_cell_padding);
$pdf->SetFont("Avenir", "B", 12);
$pdf->Cell(51, $top_cell_height, "", 0, 0, "L", false);
if($total_price >= 140){
    $pdf->Cell(50, $top_cell_height, "     Save $ " . number_format($total_savings, 2), 0, 0, "L", true);
} else {
    $pdf->Cell(50, $top_cell_height, "     Save $0", 0, 0, "L", true);
}
$pdf->Cell(1, $top_cell_height, "", 0, 0, "C", true);
$pdf->Cell(50, $top_cell_height, "", 0, 1, "L", true);

$pdf->SetY($y + $top_cell_height);
$pdf->SetFont("Avenir", "", 8);
$pdf->Cell(51, $bottom_cell_height, "", 0, 0, "L", false);
$pdf->Cell(50, $bottom_cell_height, "        with Smart Shopper Scheme", 0, 0, "L", true);

$pdf->Cell(1, $bottom_cell_height, "", 0, 0, "C", true);
$pdf->Cell(50, $bottom_cell_height, "", 0, 1, "L", true);

$y = $pdf->GetY();
$pdf->SetY($y + $padding_bottom);

$y = $pdf->GetY();

$pdf->SetFont("Avenir", "B", 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(256, 256, 256);

$pdf->Cell(0, 4, "Note: Due to rounding, the numbers shown in this table should be used only as a reference.", 0, 1, "C");

$pdf->Output();
