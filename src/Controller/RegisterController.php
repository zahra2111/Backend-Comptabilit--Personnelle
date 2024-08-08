<?php
// src/Controller/RegisterController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController
{
    private $entityManager;
    private $passwordEncoder;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
    }

    #[Route('/api/register', name: 'register_user', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $plainPassword = $data['plainPassword'] ?? null;

        if (!$email || !$plainPassword) {
            throw new BadRequestHttpException('Missing parameters');
        }

        // Validate email
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user) {
            throw new BadRequestHttpException('Email already exists');
        }

        // Create new user
        $user = new User();
        $user->setEmail($email);
        $user->setPlainPassword($plainPassword); // Use plainPassword to set password

        // Validate user
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new BadRequestHttpException('Validation failed');
        }

        // Encode password
        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));

        // Persist user
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'User registered successfully'], 201);
    }
}
