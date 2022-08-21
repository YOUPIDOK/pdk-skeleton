<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User\GenderEnum;
use DateTime;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Filter\BooleanFilter;
use Sonata\Form\Type\BooleanType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserAdmin extends AbstractAdmin
{
    private ?UserPasswordHasherInterface $userPasswordHasher = null;

    public function setUserPasswordHasher(?UserPasswordHasherInterface $userPasswordHasher): self
    {
        $this->userPasswordHasher = $userPasswordHasher;
        return $this;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('firstname')
            ->add('lastname')
            ->add('email')
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
                ->with('password')
                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'required' => (!$this->getSubject() || null === $this->getSubject()->getId()),
                    'first_options' => [
                        'label' => 'Mot de passe',
                        'row_attr' => [
                            'class' => 'col-md-6'
                        ]
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe',
                        'row_attr' => [
                            'class' => 'col-md-6'
                        ]
                    ],
                    'invalid_message' => 'Les mots de passe sont différents',
                ])
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
