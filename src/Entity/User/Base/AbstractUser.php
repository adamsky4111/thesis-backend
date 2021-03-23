<?php

namespace App\Entity\User\Base;

use App\Entity\Base\AbstractEntity;
use App\Entity\Traits\DeletedAtTrait;
use App\Entity\Traits\IsActiveTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractUser extends AbstractEntity implements UserInterface
{
    use IsActiveTrait,
        DeletedAtTrait;

    /**
     * @ORM\Column(name="email", type="string", length=180, unique=true)
     */
    protected ?string $email;

    /**
     * @ORM\Column(name="email_canonical", type="string", length=180, unique=true)
     */
    protected ?string $emailCanonical;

    /**
     * @ORM\Column(name="username", type="string", length=180, unique=true)
     */
    protected string $username;

    /**
     * @ORM\Column(name="username_canonical", type="string", length=180, unique=true)
     */
    protected string $usernameCanonical;

    /**
     * @ORM\Column(name="confirmation_token", type="string", length=180, unique=true)
     */
    protected string $confirmationToken;

    /**
     * @ORM\Column(type="json")
     */
    protected iterable $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected string $password;

    protected ?string $plainPassword;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    /**
     * @param string|null $emailCanonical
     * @return AbstractUser
     */
    public function setEmailCanonical(?string $emailCanonical): self
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsernameCanonical(): string
    {
        return $this->usernameCanonical;
    }

    /**
     * @param string $usernameCanonical
     * @return AbstractUser
     */
    public function setUsernameCanonical(string $usernameCanonical): self
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     */
    public function setConfirmationToken(string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return AbstractUser
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
