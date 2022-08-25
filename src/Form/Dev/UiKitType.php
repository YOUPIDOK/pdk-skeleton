<?php

namespace App\Form\Dev;

use App\Form\ChoicesType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UiKitType extends AbstractType
    {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('choiceJs', ChoicesType::class, [
                'placeholder' => 'Placeholder',
                'required' => true,
                'choices' => [
                    'option 1' => 1,
                    'option 2' => 2,
                    'option 3' => 3
                ],
                'choices_options' => [
                    'itemSelectText' => 'Séléctionner cette option',
                ]
            ])
//            ->add('ckeditor', CKEditorType::class, [
//                'config_name' => 'default',
//                'label' => false
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
