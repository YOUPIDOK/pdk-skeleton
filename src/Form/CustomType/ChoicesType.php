<?php

namespace App\Form\CustomType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoicesType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices_options' => []
        ]);

        parent::configureOptions($resolver);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $defaultAttributs = [
            'data-controller' => 'choices',
            'data-choices-target' => 'select',
            'data-choices-options-value' => json_encode($options['choices_options']),
        ];

        $view->vars['attr'] = array_merge($view->vars['attr'], $defaultAttributs);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}