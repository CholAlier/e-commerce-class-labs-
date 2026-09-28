<?php
require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database {
    public function getAllBrands() {
        $result = $this->conn->query('SELECT * FROM brands ORDER BY brand_name ASC');
        return $result ? $this->resultToArray($result) : [];
    }

    public function addBrand($name) {
        $stmt = $this->conn->prepare(
            'INSERT INTO brands (brand_name) VALUES (?)'
        );
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getBrandById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM brands WHERE brand_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $this->stmtFetchAssoc($stmt);
        $stmt->close();
        return $row ?: false;
    }

    public function updateBrand($id, $name) {
        $stmt = $this->conn->prepare(
            'UPDATE brands SET brand_name = ? WHERE brand_id = ?'
        );
        $stmt->bind_param('si', $name, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getAllCategories() {
        $result = $this->conn->query('SELECT * FROM categories ORDER BY cat_name ASC');
        return $result ? $this->resultToArray($result) : [];
    }

    public function addCategory($name) {
        $stmt = $this->conn->prepare(
            'INSERT INTO categories (cat_name) VALUES (?)'
        );
        $stmt->bind_param('s', $name);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getCategoryById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM categories WHERE cat_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $this->stmtFetchAssoc($stmt);
        $stmt->close();
        return $row ?: false;
    }

    public function updateCategory($id, $name) {
        $stmt = $this->conn->prepare(
            'UPDATE categories SET cat_name = ? WHERE cat_id = ?'
        );
        $stmt->bind_param('si', $name, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords) {
        $stmt = $this->conn->prepare(
            'INSERT INTO products
            (product_cat, product_brand, product_title, product_price,
             product_desc, product_image, product_keywords)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('iisdsss', $cat, $brand, $title, $price, $desc, $image_filename, $keywords);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords) {
        $stmt = $this->conn->prepare(
            'UPDATE products SET product_cat=?, product_brand=?, product_title=?,
             product_price=?, product_desc=?, product_image=?, product_keywords=?
             WHERE product_id=?'
        );
        $stmt->bind_param('iisdsssi', $cat, $brand, $title, $price, $desc, $image_filename, $keywords, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare(
            'SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_id = ?'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $this->stmtFetchAssoc($stmt);
        $stmt->close();
        return $row ?: false;
    }

    public function getFeaturedProducts($limit = 6) {
        $limit = max(1, min(20, (int)$limit));
        $sql = "SELECT p.*, c.cat_name, b.brand_name
                FROM products p
                LEFT JOIN categories c ON p.product_cat = c.cat_id
                LEFT JOIN brands b ON p.product_brand = b.brand_id
                ORDER BY RAND() LIMIT $limit";
        $result = $this->conn->query($sql);
        return $result ? $this->resultToArray($result) : [];
    }

    public function getProductsByCategory($cat_id) {
        $stmt = $this->conn->prepare(
            'SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_cat = ?'
        );
        $stmt->bind_param('i', $cat_id);
        $stmt->execute();
        $rows = $this->stmtFetchAllAssoc($stmt);
        $stmt->close();
        return $rows;
    }

    public function getProductsByBrand($brand_id) {
        $stmt = $this->conn->prepare(
            'SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_brand = ?'
        );
        $stmt->bind_param('i', $brand_id);
        $stmt->execute();
        $rows = $this->stmtFetchAllAssoc($stmt);
        $stmt->close();
        return $rows;
    }

    public function searchProducts($query) {
        $like = '%' . $query . '%';
        $stmt = $this->conn->prepare(
            'SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_title LIKE ? OR p.product_keywords LIKE ?'
        );
        $stmt->bind_param('ss', $like, $like);
        $stmt->execute();
        $rows = $this->stmtFetchAllAssoc($stmt);
        $stmt->close();
        return $rows;
    }
}
