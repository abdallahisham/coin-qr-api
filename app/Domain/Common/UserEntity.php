<?php

namespace App\Domain\Common;

class UserEntity
{
    protected $name;
    protected $phone;
    protected $balance;
    protected $suspendedBalance;

    public function __construct($name, $phone, $balance = 0.0, $suspendedBalance = 0.0)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->balance = $balance;
        $this->suspendedBalance = $suspendedBalance;
    }

    public static function fromObject($object)
    {
        return new self(
            $object->name,
            $object->phone,
            $object->balance,
            $object->suspended_balance
        );
    }

    public static function fromArray(array $user)
    {
        return new self(
            $user['name'],
            $user['phone'],
            $user['balance'],
            $user['suspended_balance']
        );
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function getSuspendedBalance()
    {
        return $this->suspendedBalance;
    }

    public function setSuspendedBalance($suspendedBalance)
    {
        $this->suspended_balance = $suspended_balance;
    }
}
