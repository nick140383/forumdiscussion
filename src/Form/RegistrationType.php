<?php

namespace App\Form;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('pseudo')
            ->add('motDePasse', PasswordType::class)
            ->add('confirm_password', PasswordType::class)



           ->add('sexe', ChoiceType::class, [
               'choices' => [
                   'Homme' => 'H',
                   'Femme' => 'F'],

                   'expanded' => true,
                    'multiple' => false


           ])

            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}