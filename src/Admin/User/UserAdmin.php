<?php

declare(strict_types=1);

namespace App\Admin\User;

use App\Enum\User\GenderEnum;
use DateTime;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Filter\Model\FilterData;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserAdmin extends AbstractAdmin
{
    private ?UserPasswordHasherInterface $userPasswordHasher = null;

    public function setUserPasswordHasher(?UserPasswordHasherInterface $userPasswordHasher): self
    {
        $this->userPasswordHasher = $userPasswordHasher;
        return $this;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('export');
        parent::configureRoutes($collection);
    }


    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('gender', ChoiceFilter::class, [
                'label' => 'Genre',
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => GenderEnum::getChoices()
                ],
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('enabled')
            ->add('isAdmin', CallbackFilter::class, [
                'callback' => static function(ProxyQueryInterface $query, string $alias, string $field, FilterData $data): bool {
                    if (!$data->hasValue()) {
                        return false;
                    }

                    $query
                        ->andWhere(
                            $query->getQueryBuilder()->expr()->orX(
                                'o.roles LIKE :roles_admin',
                                'o.roles LIKE :roles_super_admin'
                            )
                        )
                        ->setParameter('roles_admin', '%"ROLE_ADMIN"%')
                        ->setParameter('roles_super_admin', '%"ROLE_SUPER_ADMIN"%');

                    return true;
                },
                'field_type' => CheckboxType::class
            ])
            ->add('isSuperAdmin', CallbackFilter::class, [
                'callback' => static function(ProxyQueryInterface $query, string $alias, string $field, FilterData $data): bool {
                    if (!$data->hasValue()) {
                        return false;
                    }

                    $query
                        ->andWhere('o.roles LIKE :roles_super_admin_su')
                        ->setParameter('roles_super_admin_su', '%"ROLE_SUPER_ADMIN"%');

                    return true;
                },
                'field_type' => CheckboxType::class
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('gender', null, [
                'accessor' => function ($user) {
                    return GenderEnum::getGender($user->getGender());
                }
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('enabled')
            ->add('isAdmin', FieldDescriptionInterface::TYPE_BOOLEAN,[
                'accessor' => function ($user) {
                    return $user->isAdmin();
                }
            ])
            ->add('isSuperAdmin', FieldDescriptionInterface::TYPE_BOOLEAN,[
                'accessor' => function ($user) {
                    return $user->isSuperAdmin();
                }
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'edit' => ['template' => 'admin/user/list/edit_action.html.twig'],
                    'delete' => ['template' => 'admin/user/list/delete_action.html.twig'],
                    'edit_is_admin' => ['template' => 'admin/user/list/edit_is_admin_action.html.twig'],
                    'impersonate' => ['template' => 'admin/user/list/impersonate_action.html.twig'],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('user')
                ->with('profil', ['class' => 'col-md-6'])
                    ->add('firstname', null, [], ['class' => 'col-md-6'])
                    ->add('lastname')
                    ->add('gender', ChoiceType::class, [
                        'choices' => GenderEnum::getChoices(),
                        'expanded' => true,
                        'attr' => [
                            'class' => 'd-flex'
                        ]
                    ])
                ->end()

                ->with('general', ['class' => 'col-md-6'])
                    ->add('email', EmailType::class)
                ->end()
            ->end()

            ->tab('security')
                ->with('password', ['class' => 'col-md-6'])
                    ->add('plainPassword', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'required' => (!$this->getSubject() || null === $this->getSubject()->getId()),
                        'first_options' => [
                            'label' => 'Mot de passe',
                        ],
                        'second_options' => [
                            'label' => 'Confirmation du mot de passe',
                        ],
                        'invalid_message' => 'Les mots de passe sont différents',
                    ])
                ->end()
                ->with('access', ['class' => 'col-md-6'])
                    ->add('enabled')
                ->end()
            ->end()
        ;

        $this_ = $this;

        $form->getFormBuilder()->addEventListener(
            FormEvents::SUBMIT,
            function (SubmitEvent $event) use($this_){
                $user = $event->getData();
                $this_->getRequest()->getSession()->getFlashBag(    )
                    ->add('success', 'Le mot de passe à bien été reinitialiser.');
                if ($user->getPlainPassword()) {
                    $encoded = $this->userPasswordHasher->hashPassword($user, $user->getPlainPassword());
                    $user->setPassword($encoded);
                    $user->setUpdatePasswordAt(new DateTime('now'));
                    $event->setData($user);
                }
            }
        );
    }
}
