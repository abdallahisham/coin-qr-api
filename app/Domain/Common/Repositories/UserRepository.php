<?php

namespace App\Domain\Common\Repositories;

use App\Domain\Common\UserEntity;

interface UserRepository
{
    public function find($id): UserEntity;

    public function findAll($pagination = 0);

    public function findByPhone(string $phone): UserEntity;

    public function persist(UserEntity $user);
}
