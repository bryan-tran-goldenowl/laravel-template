<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserInterface
{
    public function login($email);

    public function signup($names);
}
