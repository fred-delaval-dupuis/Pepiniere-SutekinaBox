<?php

namespace App\Form;

use App\Entity\BoxProduct;
use App\Helper\TranslatorHelperTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxProductType extends AbstractType
{
    use TranslatorHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receptionDate', DateTimeType::class, [
                'widget'    => 'single_text',
                'label'     => $this->translator->trans('admin.forms.boxproducts.date'),
                'required'  => false,
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'yyyy-MM-dd',
            ])
            ->add('valid', CheckboxType::class, [
                'label'    => $this->translator->trans('admin.forms.boxproduct.checkbox'),
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoxProduct::class,
        ]);
    }
}
