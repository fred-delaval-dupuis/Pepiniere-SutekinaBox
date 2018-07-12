<?php

namespace App\Form;

use App\Entity\Box;
use App\Entity\BoxProduct;
use App\Helper\TranslatorHelperTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxProductsType extends AbstractType
{
    use TranslatorHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('boxProducts', CollectionType::class, array(
                'entry_type'    => BoxProductType::class,
                'entry_options' => ['label' => false],
            ))
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
            'data_class' => Box::class,
        ]);
    }

}
