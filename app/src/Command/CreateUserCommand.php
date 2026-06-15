<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\MapInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:create:user', description: 'save a new user in the database', help: 'verbose description and how to use', usages: ['--admin', 'name', 'password', 'email'])]
class CreateUserCommand {


    public function __invoke(
        OutputInterface $output,
        #[MapInput] CreaterUserInput $user
    ): int {

        dump($user);



        // $output->writeln(json_decode(json_encode($user), true));


        return Command::SUCCESS;
    }
}

?>
