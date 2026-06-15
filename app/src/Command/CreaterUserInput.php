<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Attribute\Argument;

class CreaterUserInput {

    #[Argument('name of the user')]
    public string $name;

    #[Argument('email of the user')]
    public string $email = '';

    #[Argument('password of the user')]
    public string $password = '';


    #[Option(shortcut: '-a')]
    public string $admin = '';
}

?>
