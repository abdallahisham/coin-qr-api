<?php

namespace App\Infrastructure\Common;

use App\Domain\Common\Repositories\UserRepository;
use App\User;

class EloquentUserRepository implements UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function find($id): UserEntity
    {
        $model = $this->model->findOrFail($id);

        return UserEntity::fromObject($model);
    }

    public function findByPhone(string $phone): UserEntity
    {
        $model = $this->model->where('phone', $phone)->firstOrFail();

        return UserEntity::fromObject($model);
    }

    public function persist(UserEntity $user)
    {
        if ($user->getId()) {
            $model = $this->model->findOrFail($user->getId());
        } else {
            $model = new User();
        }
        $model->name = $user->getName();
        $model->phone = $user->getPhone();
        $model->balance = $user->getBalance();
        $model->suspended_balance = $user->getSuspendedBalance();

        $model->save();

        return true;
    }
}
