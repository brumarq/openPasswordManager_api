<?php

namespace Services;

use Repositories\PasswordRepository;

class PasswordService
{

    private $repository;

    function __construct()
    {
        $this->repository = new PasswordRepository();
    }

    public function getAllFromUser($user)
    {
        return $this->repository->getAllFromUser($user);
    }

    public function getOne($id, $userId)
    {
        return $this->repository->getOne($id, $userId);
    }

    public function insert($item)
    {
        return $this->repository->insert($item);
    }

    public function update($password, $passwordId)
    {
        return $this->repository->update($password, $passwordId);
    }

    public function delete($passwordId, $userId)
    {
        return $this->repository->delete($passwordId, $userId);
    }
}

?>