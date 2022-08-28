<?php

namespace App\Entity\User;

use App\Enum\User\GenderEnum;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
#[ORM\Table(name: 'user__user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private string $password = '';

    #[Length(min: 8)]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 80)]
    private string $firstname = '';

    #[ORM\Column(length: 80)]
    private string $lastname = '';

    #[ORM\Column(length: 50)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $updatePasswordAt = null;

    #[ORM\Column]
    private bool $enabled = false;

    public function __toString(): string
    {
        return ($this->firstname !== '' ? ($this->firstname . ' ') : '') . $this->lastname;
    }

    public function getIdentity(?bool $addPrefix = false): string
    {
        $toString = '';
        if ($addPrefix) {
            $prefix = GenderEnum::getPrefix($this->gender);
            $toString = $prefix != GenderEnum::$prefixs[GenderEnum::NON_BINARY] ? ($prefix . ' ') : '';
        }
        $toString .= $this->firstname !== null ? (ucfirst($this->firstname) . ' ') : '';
        $toString .= $this->lastname !== null ? ucfirst($this->lastname) : '';

        return $toString;
    }

    public function getGenderValue()
    {
        if ($this->gender !== null) {
            return GenderEnum::getGender($this->gender);
        }

        return null;
    }
    public function isMan(): bool
    {
        return $this->gender === GenderEnum::MAN;
    }

    public function isWoman(): bool
    {
        return $this->gender === GenderEnum::WOMAN;
    }

    public function isNonBinary(): bool
    {
        return $this->gender === GenderEnum::NON_BINARY;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->roles, true);
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);

        return $this;
    }

    public function removeRole(string $role): self
    {
        $roles = [];

        foreach ($this->roles as $r) {
            if ($r !== $role) {
                $roles[] = $r;
            }
        }

        $this->roles = $roles;

        return $this;
    }

    public function isAdmin() :bool
    {
        return $this->hasRole('ROLE_ADMIN') || $this->hasRole('ROLE_SUPER_ADMIN');
    }

    public function isSuperAdmin() :bool
    {
        return $this->hasRole('ROLE_SUPER_ADMIN');
    }

    public function canImpersonate() :bool
    {
        return $this->hasRole('ROLE_IMPERSONATE');
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
         $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getUpdatePasswordAt(): ?DateTime
    {
        return $this->updatePasswordAt;
    }

    public function setUpdatePasswordAt(?DateTime $updatePasswordAt): self
    {
        $this->updatePasswordAt = $updatePasswordAt;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
