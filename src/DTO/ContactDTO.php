<?php


namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{

    #[Assert\NotBlank()]
	#[Assert\Length(min:1, max:30)] 
    public string $lastName ='';

    #[Assert\NotBlank()]
	#[Assert\Length(min:1, max:30)] 
    public string $firstName ='';

    #[Assert\NotBlank()]
	#[Assert\Length(min:1, max:30)] 
    public string $city ='';

    #[Assert\Length(min:10, max:13)] 
    #[Assert\Regex(pattern: "/^\+?\d{1,4}?[-.\s]?\(?\d+\)?[-.\s]?\d+[-.\s]?\d+[-.\s]?\d+$/", 
                    message: "Le numéro de téléphone n'est pas valide.")]
    public string $phone = '';

    #[Assert\NotBlank()]
    #[Assert\Length(min:6, max:60)] 
	#[Assert\Email] 
    public string $email ='';

    #[Assert\NotBlank()]
	#[Assert\Length(min:10, max:1500)] 
    public string $message ='';

    #[Assert\NotBlank()]
    public string $subject = '';
}