<?php

namespace Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Controller
{    
    function checkToken() {
        if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
            $this->respondWithError(401, "Je mag er niet in");
            return false;
        }

        try {
            $header = $_SERVER["HTTP_AUTHORIZATION"];
            $array = explode(" ", $header);
            $jwt = $array[1];

            $key = "thismustbesecret";

            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            $this->respondWithError(401, $e->getMessage());
            return false;
        }
    }

    function respond($data)
    {
        $this->respondWithCode(200, $data);
    }

    function respondWithError($httpcode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpcode, $data);
    }

    private function respondWithCode($httpcode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpcode);
        echo json_encode($data);
    }

    function createObjectFromPostedJson($className)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $object = new $className();
        foreach ($data as $key => $value) {
            if(is_object($value)) {
                continue;
            }
            $object->{$key} = $value;
        }
        return $object;
    }
}
