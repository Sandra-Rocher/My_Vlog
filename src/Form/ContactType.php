<?php

namespace App\Form;

use App\DTO\ContactDTO;
use PharIo\Manifest\Email;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'empty_data' => '',
                'label' => 'Votre nom',
            ])

            ->add('firstName', TextType::class, [
                'empty_data' => '',
                'label' => 'Votre prénom',
            ])

            ->add('city', TextType::class, [
                'empty_data' => '',
                'label' => 'Votre ville',
            ])

            ->add('email', EmailType::class, [
                'empty_data' => '',
                'label' => 'Votre email',])

            ->add('message', TextareaType::class, [
                'empty_data' => '',
                'label' => 'Votre message',
                ])

            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Question' => 'Question',
                    'Réclamation' => 'Réclamation',
                    'Recrutement' => 'Recrutement',
                    'J\'ai repéré une erreur' => 'Erreur',
                ],
                'label' => 'Sujet',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
