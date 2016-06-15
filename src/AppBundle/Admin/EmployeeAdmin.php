<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class EmployeeAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name', null, ['label' => 'Имя'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('isHidden', 'doctrine_orm_number', ['label' => 'Скрыт'], 'choice', ['choices' => ['No'=>0, "Yes"=>1]])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
//            ->add('filename', null, ['label' => 'Название'])
            ->add('name', null, ['label' => 'Имя'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('isHidden', 'boolean', ['label' => 'Скрыт'])
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
            ->add('file', 'file', $options)
            ->add('name', null, ['label' => 'Имя'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('lessons', null, ['label' => 'Курсы'])
            ->add('isHidden', 'choice', ['label' => 'Скрыт','choices' => ['No'=>0, "Yes"=>1]])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }
}
