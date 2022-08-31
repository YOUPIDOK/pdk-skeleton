<?php

namespace App\Entity\RGPD;

use App\Repository\RGPD\PrivacyPolicyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: PrivacyPolicyRepository::class)]
#[ORM\Table('rgpd__privacy_policy')]
class PrivacyPolicy
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    #[NotNull]
    private ?string $versionNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    #[NotNull]
    private ?string $body = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $implementationDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return 'Politique de confidentialité' . ($this->implementationDate !== null ? (' du ' . $this->implementationDate->format('d/m/Y h:i:s')   ) : '') ;
    }

    public function getVersionNumber(): ?string
    {
        return $this->versionNumber;
    }

    public function setVersionNumber(?string $versionNumber): self
    {
        $this->versionNumber = $versionNumber;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getImplementationDate(): ?\DateTime
    {
        return $this->implementationDate;
    }

    public function setImplementationDate(\DateTime $implementationDate): self
    {
        $this->implementationDate = $implementationDate;

        return $this;
    }
}
