<?php


namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{

    #[Assert\NotBlank()]
	#[Assert\Length(min:5, max:30)] 
    public string $lastName ='';

    #[Assert\NotBlank()]
	#[Assert\Length(min:5, max:30)] 
    public string $firstName ='';

    #[Assert\NotBlank()]
	#[Assert\Length(min:5, max:30)] 
    public string $city ='';

    #[Assert\NotBlank()]
    #[Assert\Length(min:10, max:50)] 
	#[Assert\Email] 
    public string $email ='';

	#[Assert\Length(min:10, max:500)] 
    public string $message ='';

    #[Assert\NotBlank()]
    #[Assert\Length(min:10, max:50)]
    public string $subject = '';
}