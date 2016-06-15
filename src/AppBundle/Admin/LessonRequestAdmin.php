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
//            ->add('filename')
            ->add('name', null, ['label' => 'Имя'])
            ->add('email')
            ->add('city', null, ['label' => 'Город'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('status', 'doctrine_orm_string', ['label' => 'Статус'], 'choice', ['choices' => array_flip(LessonRequest::getStatusesForAdminView())])
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
            ->add('name', null, ['label' => 'Имя'])
            ->add('email')
            ->add('city', null, ['label' => 'Город'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('status', null, ['label' => 'Статус'])
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
            ->add('name', null, ['label' => 'Имя'])
            ->add('email')
            ->add('city', null, ['label' => 'Город'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('status', 'choice', ['label' => 'Статус','choices' => array_flip(LessonRequest::getStatusesForAdminView())])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('delete');
        $collection->remove('export');
    }
}
