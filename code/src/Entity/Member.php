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
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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
            'message' => 'Member already exists!',
            'payload' => ['firstname', 'lastname']
        ]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['email'],
            'message' => 'The email {{ value }} is already in use!',
            'payload' => ['email']
        ]));

        # https://symfony.com/doc/current/reference/constraints/NotBlank.html
        $metadata->addPropertyConstraint('firstname', new Assert\NotBlank([
            'message' => 'Please provide a Firstname!',
            'payload' => ['firstname']
        ]));
        $metadata->addPropertyConstraint('lastname', new Assert\NotBlank([
            'message' => 'Please provide a Lastname!',
            'payload' => ['lastname']
        ]));
        $metadata->addPropertyConstraint('city', new Assert\NotBlank([
            'message' => 'Please provide a City!',
            'payload' => ['city']
        ]));
        $metadata->addPropertyConstraint('street', new Assert\NotBlank([
            'message' => 'Please provide a Street!',
            'payload' => ['street']
        ]));
        $metadata->addPropertyConstraint('birthday', new Assert\NotBlank([
            'message' => 'Please provide a Birthday!',
            'payload' => ['birthday']
        ]));

        # https://symfony.com/doc/current/reference/constraints/Email.html
        $metadata->addPropertyConstraint('email', new Assert\Email([
            'message' => 'The email is not a valid email!',
            'payload' => ['email']
        ]));
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }
}
