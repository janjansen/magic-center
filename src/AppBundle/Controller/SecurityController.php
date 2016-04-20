<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\CreateAdminType;
use AppBundle\Form\AdminPwdResetType;
use Doctrine\DBAL\DBALException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{

    /**
     * @Route(path="/admin/app/user/create", name="create_new_admin")
     *
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws DBALException
     * @throws \Exception
     */
    public function createAdminAction(Request $request)
    {
        $admin = new User();
        $admin->setEnabled(true);
        $form = $this->createForm(new CreateAdminType());
        $form->setData($admin);
        $form->handleRequest($request);
        if($form->isValid()) {
            $admin->addRole('ROLE_CONTENT_MANAGER');
            try {
                $this->get('fos_user.user_manager')->updateUser($admin);
            } catch(DBALException $e) {
                $form->addError(new FormError('admin already exists'));
                return $this->renderCreateAdmin($form);
            }
            $this->addFlash('notice', 'new admin was created');
            return new RedirectResponse('/admin');

        }
        return $this->renderCreateAdmin($form);
    }

    /**
     * @Route(path="/admin/app/user/{id}/reset", name="admin_reset_password")
     * @ParamConverter("admin", class="AppBundle:User")
     *
     * @param User $admin
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function adminResetPasswordAction(User $admin)
    {
        $form = $this->createForm(new AdminPwdResetType());
        $form->setData($admin);
        $form->handleRequest($this->get('request'));
        if($form->isValid()) {
            $this->get('fos_user.user_manager')->updateUser($admin);
            $this->addFlash('notice', 'success');
            return new RedirectResponse('/admin/app/admin/list');
        }
        return $this->render(
            'admin/reset_password.html.twig',
            array_merge(['form' => $form->createView()], $this->getSonataTemplateVars())
        );
    }

    /**
     * @Route(path="/admin/app/user/{id}/roles", name="admin_get_roles")
     * @ParamConverter("admin", class="AppBundle:User")
     */
    public function getRolesAction(User $admin)
    {
        $roles = $this->getParameter('security.role_hierarchy.roles');
        return $this->render(
            'admin/list_roles.html.twig',
            array_merge(['admin' => $admin, 'roles' => $roles], $this->getSonataTemplateVars())
        );
    }

    /**
     * @Route(path="/admin/app/user/{id}/roles/remove/{role}", name="admin_remove_role")
     * @ParamConverter("admin", class="AppBundle:User")
     * @param User $admin
     * @param $role
     * @return RedirectResponse
     */
    public function removeRoleAction(User $admin, $role)
    {
        if ($admin->hasRole($role)) {
            $admin->removeRole($role);
            $this->get('fos_user.user_manager')->updateUser($admin);
            $this->addFlash('success', "Роль: {$role} бы удалена");

        }
        return new RedirectResponse($this->generateUrl('admin_get_roles', ['id' => $admin->getId()]));
    }
//
    /**
     * @Route(path="/admin/app/user/{id}/roles/add/{role}", name="admin_add_role")
     * @ParamConverter("admin", class="AppBundle:User")
     * @param User $admin
     * @param $role
     * @return RedirectResponse
     */
    public function addRoleAction(User $admin, $role)
    {
        if (!$admin->hasRole($role)) {
            $admin->addRole($role);
            $this->get('fos_user.user_manager')->updateUser($admin);
            $this->addFlash('success', "Роль: {$role} бы добавлена");

        }
        return new RedirectResponse($this->generateUrl('admin_get_roles', ['id' => $admin->getId()]));
    }

    protected function renderLogin(array $data)
    {
        return $this->render(
            'admin/login.html.twig',
            array_merge($data, $this->getSonataTemplateVars())
        );
    }

    protected function renderCreateAdmin($form)
    {
        return $this->render(
            'admin/create.html.twig',
            array_merge(
                ['form' => $form->createView()],
                $this->getSonataTemplateVars(),
                $form->isSubmitted() && !$form->isValid() && $form->is ? ['errors' => $form->getErrors(true)] : []
            )

        );
    }

    protected function getSonataTemplateVars()
    {
        return [
            'base_template'   => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ];
    }
}
