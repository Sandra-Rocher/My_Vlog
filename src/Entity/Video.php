<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
// use PHPUnit\TextUI\XmlConfiguration\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
// Slug and link must be unique 
#[UniqueEntity('slug')]
#[UniqueEntity('link')]
//Create for vich uploader
#[Vich\Uploadable()]
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
    // #[Assert\Date] // In error => Date is not a string or object that implements \DateTimeInterface (symfony rules)
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

    //No not blank because the thumbnail can be null
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    //Create for vich uploader :
    #[Vich\UploadableField(mapping: 'Videos', fileNameProperty: 'thumbnail')]
    #[Assert\Image()]
    #[Assert\File(
        maxSize: '5M',
        maxSizeMessage: 'Le fichier est trop volumineux. La taille maximale est de 5 Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
        mimeTypesMessage: 'Seuls les fichiers de type JPEG, PNG, GIF, WEBP et SVG sont autorisés.'
    )]
    private ?File $thumbnailFile = null;

    //SRO workaround for update! See following link : https://github.com/dustin10/VichUploaderBundle/blob/master/docs/known_issues.md
    //SRO The file is not updated if there are no other changes in the entity
    //SRO Issue https://github.com/dustin10/VichUploaderBundle/issues/123
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;


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

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    //Create for vich uploader
    public function getThumbnailFile(): ?file
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile(?file $thumbnailFile): static
    {
        $this->thumbnailFile = $thumbnailFile;

        // Only change the updatedAt property if the file is really uploaded to avoid database updates.
        // This is needed when the file should be set when loading the entity.
        if ($this->thumbnailFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdateAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
