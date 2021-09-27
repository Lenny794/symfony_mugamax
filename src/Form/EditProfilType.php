<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('avatar_user', FileType::class, array('data_class' => null), [
            'label' => 'Avatar',
        ])
        ->add('pseudo', TextType::class, [
            'label' => 'Pseudo',
        ])
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'required' => false,
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'required' => false
        ])
        ->add('birthdate', BirthdayType::class, [
            'label' => 'Date de naissance',
            'required' => false
        ])
        ->add('country', CountryType::class, [
            'label' => 'Pays',
            'required' => false
        ])
        ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
