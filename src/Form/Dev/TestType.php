<?php

namespace App\Form\Dev;

use App\Form\CustomType\ChoicesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 10
                    ])
                ]
            ])
            ->add('choiceJs', ChoicesType::class, [
                'required' => false,
                'placeholder' => 'Placeholder',
                'choices' => [
                    'option 1' => 1,
                    'option 2' => 2,
                    'option 3' => 3
                ],
                'choices_options' => [
                    'itemSelectText' => 'Séléctionner cette option',
                ],
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
