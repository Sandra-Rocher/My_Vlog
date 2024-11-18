<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;


class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'attr' => [
                    'placeholder' => 'Los angeles, universal-studio',
                ],
                'constraints' => [
                    new Assert\Regex([
                    'pattern' => '/^[a-zA-Z0-9\- ]*$/',
                    'message' => 'Le slug peut contenir au choix : des lettres, des chiffres, des tirets et des espaces.',
                     ]),
                ],
            ])  
                                                                    
            ->add('link', TextType::class, [
                'label' => 'Link',
                'attr' => [
                    'placeholder' => 'https://www.youtube.com/watch?v=JGwWNGJdvx8',
                ],
            ])

            ->add('calendar', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date'
            ])

            ->add('comm', TextareaType::class, [
                'label' => 'Commentaire complet',
                'attr' => [
                    'rows' => 8,
                    'placeholder' => 'Blabla en détail de la vidéo avec les temps en mm.ss',
                ],
            ])

            ->add('subtitle', TextType::class, [
                'label' => 'Subtitle, lieux à voir',
                'attr' => [
                    'placeholder' => 'Monument Valley, grand canyon, L-A,etc.',
                ],
            ]) 

            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie à choisir',
                'choices' => [
                    'Voyage' => 'Voyage',
                    'Sport' => 'Sport',
                    'WW2' => 'WW2',
                ],
                'placeholder' => 'Sélectionnez ici',
            ])
            
            ->add('state', TextType::class, [
                'label' => 'Région',
                'attr' => [
                    'placeholder' => 'California ou utah',
                ],
            ])

            //Duration is a TextType for let you write like : 1.30
            ->add('duration', TextType::class, [
                'label' => 'Durée',
                'attr' => [
                    'placeholder' => '1.32',
                ],
            ])

            // No not blank because the thumbnail can be null
            ->add('thumbnailFile', FileType::class, [
                'label' => 'Image parallaxe',
                'required' => false,
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer'
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
