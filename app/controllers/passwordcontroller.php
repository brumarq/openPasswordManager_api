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
        $passwords = $this->service->getAllFromUser($userId);;

        $this->respond($passwords);
    }

    public function getOne($id)
    {
        $jwt = $this->checkToken();
        if (!$jwt)
            return;

        $password = $this->service->getOne($id, $jwt->data->id);

        if (!$password) {
            $this->respondWithError(404, "Password not found");
            return;
        }

        $this->respond($password);
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

    public function update($passwordId)
    {
        try {
            $jwt = $this->checkToken();
            if (!$jwt)
                return;

            $password = $this->createObjectFromPostedJson("Models\\Password");
            $password -> fkUserId = $jwt->data->id;

            $password = $this->service->update($password, $passwordId);

            if (!$password) {
                $this->respondWithError(404, "Password not found");
                return;
            }

            $this->respond($password);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $jwt = $this->checkToken();
            if (!$jwt)
                return;

            $this->service->delete($id, $jwt->data->id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond(true);
    }

}