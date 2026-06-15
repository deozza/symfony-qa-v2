<?php



namespace App\Service;

use App\Repository\UserRepository;
use Couchbase\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService {

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function createUser(array $payload): User {
        if(empty($payload)) {
            throw new \Exception('invalid payload');
        }

        if(count($payload) !== 3) {
            throw new \Exception('invalid payload');
        }

        if(empty(array_diff_key(['email', 'password', 'confirmPassword'], $payload)) !== true) {
            throw new \Exception('invalid payload');
        }

        foreach($payload as $key => $value) {
            if(empty($value)) {
            throw new \Exception('invalid payload');
            }
        }

        if($payload['password'] !== $payload['confirmPassword']) {
            throw new \Exception('invalid payload');
        }

        if($this->checkUserAlreadyExist($payload['email']) !==  false) {
            throw new \Exception('invalid payload');
        }

        $user = new User();
        $user->email = $payload['email'];
        $user->password = $payload['password'];

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function checkUserAlreadyExist(string $email): bool {
        return empty($this->em->getRepository(UserRepository::class)->findOneBy(['email' => $email]));
    }
}

?>
