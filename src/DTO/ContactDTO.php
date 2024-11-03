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

    #[Assert\NotBlank()]
    #[Assert\Length(min:7, max:50)] 
	#[Assert\Email] 
    public string $email ='';

    #[Assert\NotBlank()]
	#[Assert\Length(min:10, max:1500)] 
    public string $message ='';

    #[Assert\NotBlank()]
    public string $subject = '';
}