<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
//            ->add('usernameCanonical')
            ->add('email')
//            ->add('emailCanonical')
            ->add('enabled')
//            ->add('salt')
//            ->add('password')
//            ->add('lastLogin')
//            ->add('locked')
//            ->add('expired')
//            ->add('expiresAt')
//            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
//            ->add('roles')
//            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')
            ->add('id')
            ->add('scoreAmount')
            ->add('fname')
            ->add('lname')
            ->add('mname')
            ->add('bday')
            ->add('bmonth')
            ->add('byear')
            ->add('city')
            ->add('phone')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('fname')
            ->add('lname')
//            ->add('mname')
//            ->add('username')
//            ->add('usernameCanonical')
            ->add('email')
//            ->add('emailCanonical')
            ->add('enabled')
//            ->add('salt')
//            ->add('password')
//            ->add('lastLogin')
//            ->add('locked')
//            ->add('expired')
//            ->add('expiresAt')
//            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
//            ->add('roles')
//            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')

//            ->add('scoreAmount')
//            ->add('bday')
//            ->add('bmonth')
//            ->add('byear')
            ->add('city')
            ->add('phone')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'pwd_reset' => [
                        'template' => 'admin/btns/reset_btn.html.twig'
                    ],
//                    'manage_admin_roles' => [
//                        'template' => 'admin/btns/roles_btn.html.twig'
//                    ],
//                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username')
//            ->add('usernameCanonical')
            ->add('email')
//            ->add('emailCanonical')
            ->add('enabled')
//            ->add('salt')
//            ->add('password')
//            ->add('lastLogin')
//            ->add('locked')
//            ->add('expired')
//            ->add('expiresAt')
//            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
            ->add('roles')
//            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')
            ->add('id')
            ->add('scoreAmount')
            ->add('fname')
            ->add('lname')
            ->add('mname')
            ->add('bday')
            ->add('bmonth')
            ->add('byear')
            ->add('city')
            ->add('phone')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
//            ->add('expiresAt')
            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')
            ->add('id')
            ->add('scoreAmount')
            ->add('fname')
            ->add('lname')
            ->add('mname')
            ->add('bday')
            ->add('bmonth')
            ->add('byear')
            ->add('city')
            ->add('phone')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('pwd_reset', $this->getRouterIdParameter().'/reset');
        $collection->add('manage_admin_roles', $this->getRouterIdParameter().'/roles');
        $collection->remove('delete');
        $collection->remove('create');
    }
}
