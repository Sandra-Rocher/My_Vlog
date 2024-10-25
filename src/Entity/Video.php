<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[UniqueEntity('slug')]
#[UniqueEntity('link')]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Regex(
        pattern: '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/',
        message: 'Ce lien n\'est pas valide.'
    )]
    private ?string $link = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    // #[Assert\Date] // In error => Date is not a string TODO
    private ?\DateTimeInterface $calendar = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $comm = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $state = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La durée ne peut pas être vide.')]
    #[Assert\Positive(message: 'La durée doit être un nombre positif.')]
    #[Assert\Type(['type' => 'integer', 'message' => 'La durée doit être un entier.'])]
    #[Assert\LessThan(value: 3600, message: 'La durée doit être inferieur à 3600.')]
    private ?int $duration = null;


    //Getter and Setter
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
    // public function setSlugy(string $slug): static
    // {
    // //Trim remove all spaces before and after the string and preg_replace replace all spaces with -
    //         $this->slug = trim(preg_replace('/\s+/', '-', $slug));

    //         return $this;
    // }


    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getCalendar(): ?\DateTimeInterface
    {
        return $this->calendar;
    }

    public function setCalendar(\DateTimeInterface $calendar): static
    {
        $this->calendar = $calendar;

        return $this;
    }

    public function getComm(): ?string
    {
        return $this->comm;
    }

    public function setComm(string $comm): static
    {
        $this->comm = $comm;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
