<?php
require_once __DIR__ . '/../classes/CartClass.php';

class CartController {
    private $model;

    public function __construct() {
        $this->model = new CartClass();
    }

    public function isInCart($product_id, $ip) {
        return $this->model->isInCart((int)$product_id, $ip);
    }

    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        $product_id = (int)$product_id;
        $qty = (int)$qty;
        if ($product_id < 1 || $qty < 1 || !is_string($ip) || $ip === '') {
            return false;
        }

        return $this->model->addToCart($product_id, $qty, $ip, $customer_id);
    }

    public function getCartItems($ip) {
        return $this->model->getCartItems($ip);
    }

    public function getCartCount($ip) {
        return $this->model->getCartCount($ip);
    }

    public function getCartTotal($ip) {
        return $this->model->getCartTotal($ip);
    }

    public function removeFromCart($product_id, $ip) {
        $product_id = (int)$product_id;
        return $product_id > 0 && $this->model->removeFromCart($product_id, $ip);
    }

    public function updateQty($product_id, $new_qty, $ip) {
        $product_id = (int)$product_id;
        $new_qty = (int)$new_qty;
        return $product_id > 0 && $new_qty >= 1
            && $this->model->updateQty($product_id, $new_qty, $ip);
    }
}
