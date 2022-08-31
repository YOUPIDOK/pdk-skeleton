<?php

declare(strict_types=1);

namespace App\Admin\RGPD;

use DateTime;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotNull;

final class PrivacyPolicyAdmin extends AbstractAdmin
{

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'implementationDate';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('versionNumber')
            ->add('isDraft')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('isDraft')
            ->add('versionNumber')
            ->add('implementationDate', null, [
                'format' => 'd/m/Y h:i:s'
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => ['template' => 'admin/rgpd/privacy_policy/list/edit_action.html.twig']
                ],
            ])
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('delete');
        $collection->remove('export');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $disabled = !$this->getSubject()->isDraft() && $this->getSubject()->getId() != null;
        $form
            ->with('version', ['class' => 'col-md-4'])
                ->add('versionNumber', null, [
                    'disabled' => $disabled
                ])
            ->end()
            ->with('date', ['class' => 'col-md-4'])
                ->add('implementationDate', DateTimePickerType::class, [
                    'disabled' => $disabled,
                    'constraints' => [
                        new GreaterThan(new DateTime('now'))
                    ]
                ])
            ->end()
            ->with('mod', ['class' => 'col-md-4'])
                ->add('isDraft', null, [
                    'disabled' => $disabled,
                    'help' => 'Une fois le mode brouillon désactivé la politique de confidentialité sera publiée et non éditable.'
                ])
            ->end()
            ->end()
            ->add('body', CKEditorType::class, [
                'disabled' => $disabled,
                'config_name' => 'default',
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('isDraft')
            ->add('versionNumber')
            ->add('implementationDate', null, [
                'format' => 'd/m/Y h:i:s'
            ])
            ->add('createdAt', null, [
                'format' => 'd/m/Y h:i:s'
            ])
            ->add('body', null, [
                'safe' => true
            ]);
    }
}
