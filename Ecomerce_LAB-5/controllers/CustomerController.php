<?php
require_once __DIR__ . '/../classes/CustomerClass.php';

class CustomerController {
    private $model;

    public function __construct() {
        $this->model = new CustomerClass();
    }

    public function register($data) {
        if ($this->model->emailExists($data['email'])) {
            return ['success' => false, 'error' => 'Email already registered'];
        }

        if ($this->model->addCustomer(
            $data['name'], $data['email'], $data['pass'],
            $data['country'], $data['city'], $data['contact']
        )) {
            $customer = $this->model->getCustomerByEmail($data['email']);

            if ($customer) {
                return [
                    'success' => true,
                    'customer_id' => (int)$customer['customer_id'],
                    'customer_name' => $customer['customer_name'],
                    'customer_email' => $customer['customer_email'],
                    'user_role' => (int)$customer['user_role']
                ];
            }
        }

        return ['success' => false, 'error' => 'Registration failed'];
    }

    public function login($email, $pass) {
        $customer = $this->model->login($email, $pass);

        if ($customer) {
            return $customer;
        }

        return ['success' => false, 'error' => 'Invalid email or password'];
    }
}
