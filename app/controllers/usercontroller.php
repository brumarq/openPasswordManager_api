<?php

namespace Controllers;

use Exception;
use Services\UserService;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function login()
    {
        try {
            $postedUser = $this->createObjectFromPostedJson("Models\\User");
            $user = $this->service->checkEmailPassword($postedUser->email, $postedUser->password);

            if (!$user) {
                $this->respondWithError(401, "Invalid credentials");
                return;
            }

            $payload = array(
                "iss" => "http://localhost",
                "aud" => "http://localhost",
                "iat" => time(),
                "nbf" => time(),
                "exp" => time() + 600,
                "data" => array(
                    "id" => $user->userId,
                    "firstName" => $user->firstName
                )
            );

            $jwt = $this->generateJWToken($payload);

            $this->respond(["userId" => $user->userId,
                "firstName" => $user->firstName,
                "lastName" => $user->lastName,
                "email" => $user->email,
                "token" => $jwt
            ]);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function signup()
    {
        try {
            $postedUser = $this->createObjectFromPostedJson("Models\\User");
            $postedUser->password = password_hash($postedUser->password, PASSWORD_DEFAULT);
            $user = $this->service->createNewUser($postedUser);

            if (!$user) {
                $this->respondWithError(401, "Email already exists!");
                return;
            }

            $payload = array(
                "iss" => "http://localhost",
                "aud" => "http://localhost",
                "iat" => time(),
                "nbf" => time(),
                "exp" => time() + 600,
                "data" => array(
                    "id" => $user->id,
                    "firstName" => $user->firstName
                )
            );

            $jwt = $this->generateJWToken($payload);

            $this->respond([
                "userId" => $user->id,
                "firstName" => $user->firstName,
                "lastName" => $user->lastName,
                "email" => $user->email,
                "token" => $jwt
            ]);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

}