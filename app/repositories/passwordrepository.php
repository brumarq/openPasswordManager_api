<?php

namespace Repositories;

use Models\Password;
use PDO;
use PDOException;
use Repositories\Repository;

class PasswordRepository extends Repository
{
    private $userEncryptedPassword = "";

    function getEncryptedPasswordFromUser($userId){
        // Retrieve encrypted password from user
        $stmt = $this->connection->prepare("SELECT password 
                                                       FROM user
                                                       WHERE userId = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
        $user = $stmt->fetch();

        return $user->password;
    }

    function getAllFromUser($userId)
    {
        try {
            $this->userEncryptedPassword = $this->getEncryptedPasswordFromUser($userId);

            $stmt = $this->connection->prepare("SELECT * FROM password WHERE fkUserId = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $passwords = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $passwords[] = $this->rowToPassword($row);
            }

            return $passwords;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $query = "SELECT product.*, category.name as category_name FROM product INNER JOIN category ON product.category_id = category.id WHERE product.id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $product = $this->rowToProduct($row);

            return $product;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function rowToPassword($row) {
        $password = new Password();
        $password->passwordId = $row['passwordId'];
        $password->websiteUrl = $row['websiteUrl'];
        $password->email = $row['email'];

        $decrypted_string=openssl_decrypt($row['password'],"AES-128-ECB",$this->userEncryptedPassword);

        $password->password = $decrypted_string;

        return $password;
    }

    function insert($password)
    {
        try {
            $this->userEncryptedPassword = $this->getEncryptedPasswordFromUser($password->fkUserId);

            // Encrypt password with master key of user
            $encryptedPassword=openssl_encrypt($password->password,"AES-128-ECB",$this->userEncryptedPassword);

            // Insert new password into table
            $stmt = $this->connection->prepare("INSERT INTO password (websiteUrl, email, password, fkUserId) VALUES (?,?,?,?)");
            $stmt->execute([$password->websiteUrl, $password->email, $encryptedPassword, $password->fkUserId]);
            $password->passwordId = $this->connection->lastInsertId();

            return $password;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    function update($product, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE product SET name = ?, price = ?, description = ?, image = ?, category_id = ? WHERE id = ?");

            $stmt->execute([$product->name, $product->price, $product->description, $product->image, $product->category_id, $id]);

            return $this->getOne($product->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM product WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
