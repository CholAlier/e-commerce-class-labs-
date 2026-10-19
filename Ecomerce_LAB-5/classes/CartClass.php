<?php
require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database {
    public function isInCart($product_id, $ip) {
        $stmt = $this->conn->prepare(
            'SELECT 1 FROM cart WHERE p_id = ? AND ip_add = ? LIMIT 1'
        );
        $stmt->bind_param('is', $product_id, $ip);
        $stmt->execute();
        $inCart = (bool)$this->stmtFetchAssoc($stmt);
        $stmt->close();
        return $inCart;
    }

    public function addToCart($product_id, $qty, $ip, $customer_id = null) {
        $stmt = $this->conn->prepare(
            'INSERT INTO cart (p_id, ip_add, qty) VALUES (?, ?, ?)'
        );
        $stmt->bind_param('isi', $product_id, $ip, $qty);
        $saved = $stmt->execute();
        $stmt->close();
        return $saved;
    }

    public function getCartItems($ip) {
        $stmt = $this->conn->prepare(
            'SELECT cart.*, products.product_title, products.product_price, products.product_image
             FROM cart
             JOIN products ON cart.p_id = products.product_id
             WHERE cart.ip_add = ?
             ORDER BY products.product_title ASC'
        );
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $items = $this->stmtFetchAllAssoc($stmt);
        $stmt->close();
        return $items;
    }

    public function getCartCount($ip) {
        $stmt = $this->conn->prepare(
            'SELECT COUNT(*) AS item_count FROM cart WHERE ip_add = ?'
        );
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $row = $this->stmtFetchAssoc($stmt);
        $stmt->close();
        return (int)($row['item_count'] ?? 0);
    }

    public function getCartTotal($ip) {
        $total = 0.0;
        foreach ($this->getCartItems($ip) as $item) {
            $total += (int)$item['qty'] * (float)$item['product_price'];
        }
        return $total;
    }

    public function removeFromCart($product_id, $ip) {
        $stmt = $this->conn->prepare(
            'DELETE FROM cart WHERE p_id = ? AND ip_add = ?'
        );
        $stmt->bind_param('is', $product_id, $ip);
        $removed = $stmt->execute();
        $stmt->close();
        return $removed;
    }

    public function updateQty($product_id, $new_qty, $ip) {
        if (!is_int($new_qty) || $new_qty < 1) {
            return false;
        }

        $stmt = $this->conn->prepare(
            'UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?'
        );
        $stmt->bind_param('iis', $new_qty, $product_id, $ip);
        $updated = $stmt->execute();
        $stmt->close();
        return $updated;
    }
}
