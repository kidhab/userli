<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class RecoveryToken
{
    #[UserPassword(message: 'form.wrong-password')]
    public string $password;
}
