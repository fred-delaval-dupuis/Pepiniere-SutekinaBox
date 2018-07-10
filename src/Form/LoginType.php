<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/07/2018
 * Time: 17:15
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => false, 'attr' => ['placeholder' => 'E-mail']])
            ->add('password', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => '********']])
            ->add('submit', SubmitType::class, ['label' => 'Connexion'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }

}