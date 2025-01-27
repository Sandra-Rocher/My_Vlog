<?php


namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{

    #[Assert\NotBlank(
        message: "Le champ nom ne peut pas être vide. Veuillez saisir votre nom."
    )]
    #[Assert\Length(
        min: 2,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractère.",
        max: 30,
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÿ\s'-]+$/",
        message: "Le nom ne peut contenir que des lettres, des espaces, des apostrophes ou des tirets."
    )]
    public string $lastName = '';
    
    #[Assert\NotBlank(
        message: "Le champ prénom ne peut pas être vide. Veuillez saisir votre prénom."
    )]
    #[Assert\Length(
        min: 2,
        minMessage: "Le prénom doit contenir au moins {{ limit }} caractère.",
        max: 30,
        maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÿ\s'-]+$/",
        message: "Le nom ne peut contenir que des lettres, des espaces, des apostrophes ou des tirets."
    )]
    public string $firstName = '';

    #[Assert\NotBlank(
        message: "Le champ sujet ne peut pas être vide. Veuillez sélectionner ou indiquer un sujet."
    )]
    public string $subject = '';

    #[Assert\NotBlank(
        message: "Le champ ville ne peut pas être vide. Veuillez saisir un nom de ville."
    )]
    #[Assert\Length(
        min: 2,
        minMessage: "Le nom de la ville doit contenir au moins {{ limit }} caractère.",
        max: 30,
        maxMessage: "Le nom de la ville ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-ZÀ-ÿ\s'-]+$/",
        message: "Le nom ne peut contenir que des lettres, des espaces, des apostrophes ou des tirets."
    )]
    public string $city = '';

    #[Assert\Length(
        min: 12,
        max: 12,
        exactMessage: "Le numéro de téléphone doit comporter exactement 12 caractères."
    )]
    #[Assert\Regex(
        pattern: "/^\+33\d{9}$/",
        message: "Le numéro de téléphone doit commencer par +33 suivi de 9 chiffres."
    )]
    public string $phone = '+33';

    #[Assert\NotBlank(
        message: "Le champ email ne peut pas être vide. Veuillez saisir une adresse email valide."
    )]
    #[Assert\Length(
        min: 7,
        minMessage: "L'adresse email doit contenir au moins {{ limit }} caractères.",
        max: 30,
        maxMessage: "L'adresse email ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Email(
        message: "L'adresse email saisie n'est pas valide. Veuillez saisir une adresse correcte."
    )]
    public string $email = '';

    #[Assert\NotBlank(
        message: "Le champ message ne peut pas être vide. Veuillez écrire entre 10 et 1500 caractères."
    )]
    #[Assert\Length(
        min: 10,
        minMessage: "Le message doit contenir au moins {{ limit }} caractères.",
        max: 1500,
        maxMessage: "Le message ne peut pas dépasser {{ limit }} caractères."
    )]
    public string $message = '';
    
}