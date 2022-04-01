<?php

namespace Services;

use Repositories\UserRepository;

class UserService
{

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    function checkEmailPassword($email, $password)
    {
        return $this->repository->checkEmailPassword($email, $password);
    }

    function createNewUser($user)
    {
        return $this->repository->createNewUser($user);
    }
}