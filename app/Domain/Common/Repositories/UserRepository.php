<?php

namespace App\Domain\Common\Repositories;

use App\Domain\Common\UserEntity;

interface UserRepository
{
    public function find($id): UserEntity;

    public function findByPhone(string $phone): UserEntity;

    public function update(UserEntity $user);
}
