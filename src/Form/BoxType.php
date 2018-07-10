<?php

namespace App\Form;

use App\Entity\Box;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class BoxType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * BoxType constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('budget', MoneyType::class)
            ->add('submit', SubmitType::class, ['label' => $this->translator->trans('admin.box.form.submit')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Box::class,
        ]);
    }
}
