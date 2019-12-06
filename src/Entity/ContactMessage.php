<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactMessageRepository")
 */
class ContactMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"default"=""})
     */
    private $fromName = '';

    /**
     * @ORM\Column(type="string", length=25, options={"default"=""})
     */
    private $fromPhoneNumber = '';

    /**
     * @ORM\Column(type="string", length=255, options={"default"=""})
     */
    private $fromEmail = '';

    /**
     * @ORM\Column(type="text", length=32000, options={"default"=""})
     */
    private $message = '';

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=50, options={"default"=""})
     */
    private $fromIp = '';

    /**
     * @ORM\Column(type="string", length=50, options={"default"=""})
     */
    private $label = '';

    /**
     * @ORM\Column(type="string", length=50, options={"default"=""})
     */
    private $keepedBy = '';

    /**
     * @ORM\Column(type="boolean", options={"default"="0"})
     */
    private $closed = false;

    public function __construct()
    {
        $this->setClosed(false);
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromPhoneNumber(): string
    {
        return $this->fromPhoneNumber;
    }

    public function setFromPhoneNumber(string $fromPhoneNumber): self
    {
        $this->fromPhoneNumber = $fromPhoneNumber;

        return $this;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFromIp(): string
    {
        return $this->fromIp;
    }

    public function setFromIp(string $fromIp): self
    {
        $this->fromIp = $fromIp;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getKeepedBy(): string
    {
        return $this->keepedBy;
    }

    public function setKeepedBy(string $keepedBy): self
    {
        $this->keepedBy = $keepedBy;

        return $this;
    }

    public function getClosed(): bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }
}
