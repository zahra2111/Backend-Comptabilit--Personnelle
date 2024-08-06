<?php
namespace App\Entity;

use App\Controller\CurrentUserController;
use App\Controller\LogoutController;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['user:read']],
    collectionOperations: [
        'get',
        'post',
        'get_current_user' => [
            'method' => 'GET',
            'path' => '/current_user',
            'controller' => CurrentUserController::class,
            'pagination_enabled' => false,
            'openapi_context' => [
                'summary' => 'Get details of the currently authenticated user',
                'responses' => [
                    '200' => [
                        'description' => 'Authenticated user details',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object'
                                ]
                            ]
                        ]
                    ],
                    '401' => [
                        'description' => 'User not authenticated',
                    ]
                ]
            ]
        ],
        
    ],
    itemOperations: [
        'get',
        'put',
        'delete'
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $NomPrenom = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    private ?string $plainPassword = null;

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->NomPrenom;
    }

    public function setNomPrenom(string $NomPrenom): static
    {
        $this->NomPrenom = $NomPrenom;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->NomPrenom;
    }

    public function getUsername(): string
    {
        return (string) $this->NomPrenom;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'NomPrenom' => $this->getNomPrenom(),
            'roles' => $this->getRoles(),
            'email' => $this->getEmail(),
        ];
    }
}
