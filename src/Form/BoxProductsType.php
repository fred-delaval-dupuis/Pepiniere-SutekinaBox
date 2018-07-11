<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class BoxProductsType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * BoxProductsType constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


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
                'label' => $this->translator->trans('forms.boxproducts.save'),
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans('forms.boxproducts.submit'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
