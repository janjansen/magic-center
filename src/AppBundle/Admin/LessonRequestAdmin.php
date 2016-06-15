<?php

namespace AppBundle\Admin;

use AppBundle\Entity\LessonRequest;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class LessonRequestAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('filename')
            ->add('name')
            ->add('email')
            ->add('city')
            ->add('phone')
            ->add('status')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
//            ->add('filename')
            ->add('name')
            ->add('email')
            ->add('city')
            ->add('phone')
            ->add('status')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();

        $options = ['required' => false];
        if ($image && $image->getWebPath()) {
            $options['help'] = '<img src="'.$image->getWebPath().'" class="admin-preview" />';
        }

        $formMapper
//            ->add('id')
            ->add('file', 'file', $options)
            ->add('name')
            ->add('email')
            ->add('city')
            ->add('phone')
            ->add('status', 'choice', ['choices' => array_flip(LessonRequest::getStatusesForAdminView())])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('filename')
            ->add('name')
            ->add('email')
            ->add('city')
            ->add('phone')
            ->add('status')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }
}
