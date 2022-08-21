<?php

namespace App\Controller\Admin;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAdminController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin/app/user-user/add-admin-role/{user}', name: 'user_admin__add_admin_role')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function addAdminRole(User $user, Request $request): Response
    {
        $user->addRole('ROLE_ADMIN');
        $this->em->flush();

        $this->addFlash('success', 'Les droits administrateur ont bien été ajoutés à ' .$user->getIdentity());

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/app/user-user/remove-admin-role/{user}', name: 'user_admin__remove_admin_role')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function removeAdminRole(User $user, Request $request): Response
    {
        $user->removeRole('ROLE_SUPER_ADMIN');
        $user->removeRole('ROLE_ADMIN');

        $this->em->flush();

        $this->addFlash('success', 'Les droits administrateur ont bien été retirés à ' .$user->getIdentity());

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/app/user-user/add-super-admin-role/{user}', name: 'user_admin__add_super_admin_role')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function addSuperAdminRole(User $user, Request $request): Response
    {
        $user->addRole('ROLE_ADMIN');
        $user->addRole('ROLE_SUPER_ADMIN');
        $this->em->flush();

        $this->addFlash('success', 'Les droits super administrateur ont bien été ajoutés à ' .$user->getIdentity());

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/app/user-user/remove-super-admin-role/{user}', name: 'user_admin__remove_super_admin_role')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function removeSuperAdminRole(User $user, Request $request): Response
    {
        $user->removeRole('ROLE_SUPER_ADMIN');

        $this->em->flush();

        $this->addFlash('success', 'Les droits super administrateur ont bien été retirés à ' .$user->getIdentity());

        return $this->redirect($request->headers->get('referer'));
    }
}