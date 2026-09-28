<?php
require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductClass();
    }

    public function getAllBrands() { return $this->model->getAllBrands(); }
    public function getBrandById($id) { return $this->model->getBrandById($id); }

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

    public function saveProduct($data, $imageUpload = null, $id = null) {
        $categoryId = filter_var($data['product_cat'] ?? null, FILTER_VALIDATE_INT);
        $brandId = filter_var($data['product_brand'] ?? null, FILTER_VALIDATE_INT);
        $title = is_string($data['product_title'] ?? null)
            ? trim(strip_tags($data['product_title']))
            : '';
        $priceInput = $data['product_price'] ?? null;
        $price = is_string($priceInput) || is_int($priceInput) || is_float($priceInput)
            ? filter_var($priceInput, FILTER_VALIDATE_FLOAT)
            : false;
        $description = is_string($data['product_desc'] ?? null)
            ? trim(strip_tags($data['product_desc']))
            : '';
        $keywords = is_string($data['product_keywords'] ?? null)
            ? trim(strip_tags($data['product_keywords']))
            : '';

        if (
            $categoryId === false || $categoryId <= 0 ||
            $brandId === false || $brandId <= 0 ||
            $title === '' || strlen($title) > 200 ||
            $price === false || !is_finite((float)$price) || $price < 0 ||
            strlen($description) > 500 || strlen($keywords) > 100
        ) {
            return ['success' => false, 'error' => 'Please complete the product fields correctly.'];
        }

        if (!$this->model->getCategoryById($categoryId) || !$this->model->getBrandById($brandId)) {
            return ['success' => false, 'error' => 'Select an existing category and brand.'];
        }

        $product = null;
        if ($id !== null) {
            $product = $this->model->getProductById($id);
            if (!$product) {
                return ['success' => false, 'error' => 'Product not found.'];
            }
        }

        $image = $product['product_image'] ?? null;
        $newImage = null;
        if (is_array($imageUpload) && ($imageUpload['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $upload = $this->storeProductImage($imageUpload);
            if (!$upload['success']) {
                return $upload;
            }
            $image = $upload['filename'];
            $newImage = $image;
        }

        $saved = $id === null
            ? $this->model->addProduct($categoryId, $brandId, $title, $price, $description, $image, $keywords)
            : $this->model->updateProduct($id, $categoryId, $brandId, $title, $price, $description, $image, $keywords);

        if (!$saved) {
            if ($newImage !== null) {
                @unlink(__DIR__ . '/../images/products/' . $newImage);
            }
            return ['success' => false, 'error' => 'Unable to save the product.'];
        }

        if ($newImage !== null && !empty($product['product_image']) && $product['product_image'] !== $newImage) {
            $oldImage = __DIR__ . '/../images/products/' . basename($product['product_image']);
            if (is_file($oldImage)) {
                @unlink($oldImage);
            }
        }

        return ['success' => true, 'message' => $id === null ? 'Product added.' : 'Product updated.'];
    }

    private function storeProductImage($upload) {
        if (!is_array($upload) || ($upload['error'] ?? null) !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'The product image upload failed.'];
        }

        if (!isset($upload['tmp_name'], $upload['size']) || !is_string($upload['tmp_name']) || $upload['size'] > 2 * 1024 * 1024) {
            return ['success' => false, 'error' => 'Image is too large. Maximum is 2MB.'];
        }

        $imageTypes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_GIF => 'gif',
            IMAGETYPE_WEBP => 'webp'
        ];
        $imageInfo = @getimagesize($upload['tmp_name']);
        if ($imageInfo === false || !isset($imageTypes[$imageInfo[2]]) || !is_uploaded_file($upload['tmp_name'])) {
            return ['success' => false, 'error' => 'Choose a valid JPEG, PNG, GIF, or WebP image.'];
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $imageTypes[$imageInfo[2]];
        $destination = __DIR__ . '/../images/products/' . $filename;
        if (!move_uploaded_file($upload['tmp_name'], $destination)) {
            return ['success' => false, 'error' => 'Unable to store the uploaded image.'];
        }

        return ['success' => true, 'filename' => $filename];
    }

    public function getProductById($id) { return $this->model->getProductById($id); }
    public function getFeaturedProducts($limit = 6) { return $this->model->getFeaturedProducts($limit); }
    public function getProductsByCategory($id) { return $this->model->getProductsByCategory($id); }
    public function getProductsByBrand($id) { return $this->model->getProductsByBrand($id); }
    public function searchProducts($query) { return $this->model->searchProducts($query); }
}
