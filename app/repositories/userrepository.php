<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

class UserRepository extends Repository
{
    function checkEmailPassword($email, $password)
    {
        try {
            // retrieve the user with the given username
            $stmt = $this->connection->prepare("SELECT userId, firstName, lastName, email, password 
                                                       FROM user
                                                       WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            if (!$user) {
                return false;
            }
            // verify if the password matches the hash in the database
            $result = $this->verifyPassword($password, $user->password);

            if (!$result)
                return false;

            // do not pass the password hash to the caller
            $user->password = "";

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function createNewUser($user)
    {
        try {
            // retrieve the user with the given email and check it exists
            $stmt = $this->connection->prepare(" SELECT firstName, lastName, email, password 
                                                       FROM user
                                                       WHERE email = :email");
            $stmt->execute(['email' => $user->email]);

            if ($stmt->rowCount() != 0) {
                return false;
            }

            // insert new user into the database
            $stmt = $this->connection->prepare(" INSERT INTO user (firstName, lastName, email, password) 
                                                       VALUES (:firstName, :lastName, :email, :password)");

            $stmt->execute([
                'firstName' => $user -> firstName,
                'lastName' => $user -> lastName,
                'email' => $user -> email,
                'password' => $user -> password
            ]);

            $user->id = $this->connection->lastInsertId();

            return $user;

        } catch (PDOException $e) {
            echo $e;
        }
    }

    // hash the password (currently uses bcrypt)
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // verify the password hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }
}
