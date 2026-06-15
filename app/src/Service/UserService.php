<?php
namespace App\Service;

class UserService {

    public function __construct(EntityManagerInterface $em) {

    }

    public function validateRegisterPayload(array $payload) {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

    }

    public function checkUserAlreadyExist(string $email): bool {

    }
}

?>
