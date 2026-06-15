<?php



namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserService {

    private UserRepository $userRepository;
    private EntityManagerInterface $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em) {
        $this->userRepository = $userRepository;
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
        return empty($this->userRepository->findOneBy(['email' => $email]));
    }
}

?>
