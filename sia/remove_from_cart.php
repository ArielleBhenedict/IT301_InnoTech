<?php
session_start();

// Check if productId is received
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['productId'])) {
    $productId = $data['productId'];
    
    // Remove product from the cart session
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($productId) {
            return $item['id'] !== $productId;
        });
    }
    echo json_encode(['status' => 'success']);
}
?>
