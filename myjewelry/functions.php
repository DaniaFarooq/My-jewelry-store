<?php
session_start();

function getProducts() {
    return [
        ["ring.webp", "Elegant Ring", 50],
        ["bracelet.webp", "Bow Bracelet", 30],
        ["butterfly.webp", "Wings Earrings", 40],
        ["necklace.avif", "Stone Necklace", 90],
        ["bangles.webp", "Engraved Bangles", 50],
        ["brooches.webp", "Brooches", 30]
    ];
}

function addToCart($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
}
?>