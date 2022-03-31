<?php

namespace Controllers;

use Exception;
use Services\PasswordService;
use Services\UserService;

class PasswordController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new PasswordService();
    }

    public function getAll()
    {
        $jwt = $this->checkToken();
        if (!$jwt)
            return;

        $userId = $jwt->data->id;
        $products = $this->service->getAllFromUser($userId);;

        $this->respond($products);
    }

    public function getOne($id)
    {
        $product = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the product is not found in the DB
        if (!$product) {
            $this->respondWithError(404, "Product not found");
            return;
        }

        $this->respond($product);
    }

    public function create()
    {
        try {
            $jwt = $this->checkToken();
            if (!$jwt)
                return;

            $password = $this->createObjectFromPostedJson("Models\\Password");
            $password -> fkUserId = $jwt->data->id;

            $password = $this->service->insert($password);
            $this->respond($password);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

    }

    public function update($id)
    {
        try {
            $product = $this->createObjectFromPostedJson("Models\\Product");
            $product = $this->service->update($product, $id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($product);
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }

}