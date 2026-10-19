<?php
require_once __DIR__ . '/../core/db_class.php';

class CustomerClass extends Database {
    public function emailExists($email) {
        $stmt = $this->conn->prepare(
            'SELECT customer_email FROM customer WHERE customer_email = ?'
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function addCustomer($name, $email, $pass, $country, $city, $contact, $image = null) {
        $hash = password_hash($pass, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare(
            'INSERT INTO customer
            (customer_name, customer_email, customer_pass, customer_country,
               customer_city, customer_contact, customer_image)
               VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('sssssss', $name, $email, $hash, $country, $city, $contact, $image);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function getCustomerByEmail($email) {
        $stmt = $this->conn->prepare(
            'SELECT * FROM customer WHERE customer_email = ? LIMIT 1'
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $row = $this->stmtFetchAssoc($stmt);
        $stmt->close();

        return $row ?: false;
    }

    public function login($email, $pass) {
        $row = $this->getCustomerByEmail($email);

        if ($row && password_verify($pass, $row['customer_pass'])) {
            return $row;
        }

        return false;
    }
}
