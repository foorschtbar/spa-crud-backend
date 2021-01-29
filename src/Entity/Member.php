<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        # https://symfony.com/doc/current/reference/constraints/UniqueEntity.html
        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['firstname', 'lastname'],
            'message' => 'Member already exists.',
        ]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['email'],
            'message' => 'The email {{ value }} is already in use.',
        ]));

        # https://symfony.com/doc/current/reference/constraints/NotBlank.html
        $metadata->addPropertyConstraint('firstname', new Assert\NotBlank([
            'message' => 'Please provide a Firstname!'
        ]));
        $metadata->addPropertyConstraint('lastname', new Assert\NotBlank([
            'message' => 'Please provide a Lastname!'
        ]));
        $metadata->addPropertyConstraint('address', new Assert\NotBlank([
            'message' => 'Please provide a Address!'
        ]));

        # https://symfony.com/doc/current/reference/constraints/Email.html
        $metadata->addPropertyConstraint('email', new Assert\Email([
            'message' => 'The email {{ value }} is not a valid email.'
        ]));
    }
}
