<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    private $roles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Box", mappedBy="user")
     */
    private $boxes;

    /**
     * User constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param ArrayCollection $roles
     * @param Service $service
     */
    public function __construct(string $firstName = null, string $lastName = null, string $email = null, string $password = null, ArrayCollection $roles = null, Service $service = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles ?: new ArrayCollection();
        $this->boxes = new ArrayCollection();
        $this->roles = $roles;
        $this->service = $service;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
        return;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->getTitle();
        }
        return $roles;
    }

    /**
     * @param Role $role
     * @return User
     */
    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param Role $role
     * @return User
     */
    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    /**
     * @return Service|null
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * @param Service|null $service
     * @return User
     */
    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|Box[]
     */
    public function getBoxes(): Collection
    {
        return $this->boxes;
    }

    /**
     * @param Box $box
     * @return User
     */
    public function addBox(Box $box): self
    {
        if (!$this->boxes->contains($box)) {
            $this->boxes[] = $box;
            $box->setUser($this);
        }

        return $this;
    }

    /**
     * @param Box $box
     * @return User
     */
    public function removeBox(Box $box): self
    {
        if ($this->boxes->contains($box)) {
            $this->boxes->removeElement($box);
            // set the owning side to null (unless already changed)
            if ($box->getUser() === $this) {
                $box->setUser(null);
            }
        }

        return $this;
    }

}
