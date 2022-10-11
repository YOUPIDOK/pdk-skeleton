<?php

namespace App\Form\CustomType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaAutoResizeType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $defaultAttributs = [
            'data-controller' => 'form--textarea-auto-resize',
            'data-form--textarea-auto-resize-target' => 'textarea',
            'data-action' => 'input->form--textarea-auto-resize#resize'
        ];

        $view->vars['attr'] = array_merge($view->vars['attr'], $defaultAttributs);
    }

    public function getParent()
    {
        return TextareaType::class;
    }
}