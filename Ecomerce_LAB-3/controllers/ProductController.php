<?php
require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductClass();
    }

    public function getAllBrands() { return $this->model->getAllBrands(); }
    public function getBrandById($id) { return $this->model->getBrandById($id); }

    public function addBrand($name) {
        return $this->saveBrand($name);
    }

    public function updateBrand($id, $name) {
        return $this->saveBrand($name, $id);
    }

    public function saveBrand($name, $id = null) {
        $name = is_string($name) ? trim(strip_tags($name)) : '';
        if ($name === '' || strlen($name) > 100) {
            return ['success' => false, 'error' => 'Brand name is required (maximum 100 characters).'];
        }

        if ($id !== null && !$this->model->getBrandById($id)) {
            return ['success' => false, 'error' => 'Brand not found.'];
        }

        $saved = $id === null
            ? $this->model->addBrand($name)
            : $this->model->updateBrand($id, $name);

        return $saved
            ? ['success' => true, 'message' => $id === null ? 'Brand added.' : 'Brand updated.']
            : ['success' => false, 'error' => 'Unable to save the brand.'];
    }

    public function getAllCategories() { return $this->model->getAllCategories(); }
    public function getCategoryById($id) { return $this->model->getCategoryById($id); }

    public function addCategory($name) {
        return $this->saveCategory($name);
    }

    public function updateCategory($id, $name) {
        return $this->saveCategory($name, $id);
    }

    public function saveCategory($name, $id = null) {
        $name = is_string($name) ? trim(strip_tags($name)) : '';
        if ($name === '' || strlen($name) > 100) {
            return ['success' => false, 'error' => 'Category name is required (maximum 100 characters).'];
        }

        if ($id !== null && !$this->model->getCategoryById($id)) {
            return ['success' => false, 'error' => 'Category not found.'];
        }

        $saved = $id === null
            ? $this->model->addCategory($name)
            : $this->model->updateCategory($id, $name);

        return $saved
            ? ['success' => true, 'message' => $id === null ? 'Category added.' : 'Category updated.']
            : ['success' => false, 'error' => 'Unable to save the category.'];
    }

    public function getAdminDashboardStats() { return $this->model->getAdminDashboardStats(); }
    public function getProductById($id) { return $this->model->getProductById($id); }
    public function getFeaturedProducts($limit = 6) { return $this->model->getFeaturedProducts($limit); }
    public function getProductsByCategory($id) { return $this->model->getProductsByCategory($id); }
    public function getProductsByBrand($id) { return $this->model->getProductsByBrand($id); }
    public function searchProducts($query) { return $this->model->searchProducts($query); }
}
