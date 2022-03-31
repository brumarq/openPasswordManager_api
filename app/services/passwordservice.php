<?php
namespace Services;

use Repositories\PasswordRepository;

class PasswordService {

    private $repository;

    function __construct()
    {
        $this->repository = new PasswordRepository();
    }

    public function getAllFromUser($user) {
        return $this->repository->getAllFromUser($user);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function insert($item) {
        return $this->repository->insert($item);
    }

    public function update($item, $id) {
        return $this->repository->update($item, $id);
    }

    public function delete($item) {
        return $this->repository->delete($item);
    }
}

?>