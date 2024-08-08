<?php
namespace App\Entity;
// Import the Groups annotation
use Symfony\Component\Serializer\Annotation\Groups;

use App\Controller\CurrentUserController;
use App\Controller\LogoutController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
        'change_password' => [
            'method' => 'POST',
            'path' => '/change_password',
            'controller' => ChangePasswordController::class,
            'openapi_context' => [
                'summary' => 'Change user password',
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'email' => ['type' => 'string'],
                                    'currentPassword' => ['type' => 'string'],
                                    'newPassword' => ['type' => 'string']
                                ],
                                'required' => ['email', 'currentPassword', 'newPassword'],
                            ],
                        ],
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Password changed successfully',
                    ],
                    '400' => [
                        'description' => 'Invalid credentials or missing parameters',
                    ]
                ]
            ]
        ],
    ],
    
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * @Groups({"user:read"})
     */
    private ?int $id = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    /**
     * @Groups({"user:read"})
     */
    private ?string $email = null;

    private ?string $plainPassword = null;

    #[ORM\OneToMany(mappedBy: 'usr', targetEntity: Bank::class)]
    /**
     * @Groups({"user:read"})
     */
    private Collection $bankAccounts;



    public function __construct()
    {
        $this->banks = new ArrayCollection();
        $this->bankAccounts = new ArrayCollection();
    }
    
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

     public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
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
            'roles' => $this->getRoles(),
            'email' => $this->getEmail(),
        ];
    }

    /**
     * @return Collection<int, Bank>
     */
    public function getBanks(): Collection
    {
        return $this->banks;
    }

    public function addBank(Bank $bank): static
    {
        if (!$this->banks->contains($bank)) {
            $this->banks->add($bank);
            $bank->setUserId($this);
        }

        return $this;
    }

    public function removeBank(Bank $bank): static
    {
        if ($this->banks->removeElement($bank)) {
            // set the owning side to null (unless already changed)
            if ($bank->getUserId() === $this) {
                $bank->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bank>
     */
    public function getBankAccounts(): Collection
    {
        return $this->bankAccounts;
    }

    public function addBankAccount(Bank $bankAccount): static
    {
        if (!$this->bankAccounts->contains($bankAccount)) {
            $this->bankAccounts->add($bankAccount);
            $bankAccount->setUsr($this);
        }

        return $this;
    }

    public function removeBankAccount(Bank $bankAccount): static
    {
        if ($this->bankAccounts->removeElement($bankAccount)) {
            // set the owning side to null (unless already changed)
            if ($bankAccount->getUsr() === $this) {
                $bankAccount->setUsr(null);
            }
        }

        return $this;
    }

  
}
