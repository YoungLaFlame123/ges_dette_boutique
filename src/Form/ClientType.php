<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Importez le type SubmitType depuis Symfony
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'required'=> true,
                
            ])
            ->add('telephone', TelType::class, [
                'required' => false,
                
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                
            ])
            ->add('createAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('updateAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre', // Texte du bouton
                'attr' => [
                    'class' => 'mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded' // Classes CSS pour le style
                ]
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
