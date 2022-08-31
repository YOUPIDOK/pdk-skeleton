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
use Symfony\Component\Validator\Constraints\GreaterThan;

final class CGUAdmin extends AbstractAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'implementationDate';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter->add('versionNumber');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('versionNumber')
            ->add('implementationDate', null, [
                'format' => 'd/m/Y h:i:s'
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                ],
            ])
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('delete');
        $collection->remove('edit');
        $collection->remove('export');
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('version', ['class' => 'col-md-6'])
            ->add('versionNumber')
            ->end()
            ->with('date', ['class' => 'col-md-6'])
            ->add('implementationDate', DateTimePickerType::class, [
                'constraints' => [
                    new GreaterThan(new DateTime('now'))
                ]
            ])
            ->end()
            ->end()
            ->add('body', CKEditorType::class, [
                'config_name' => 'default',
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('versionNumber')
            ->add('implementationDate', null, [
                'format' => 'd/m/Y h:i:s'
            ])
            ->add('body', null, [
                'safe' => true
            ]);
    }
}
