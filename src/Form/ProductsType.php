<?php

namespace App\Form;

use App\Entity\Product;
use App\Helper\TranslatorHelperTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    use TranslatorHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('products', EntityType::class, [
                'class'         => Product::class,
                'choice_value'  => 'id',
                'choice_label'  => 'label',
                'multiple'      => true,
                'expanded'      => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('admin.forms.btn.save'),
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('admin.forms.btn.submit'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
