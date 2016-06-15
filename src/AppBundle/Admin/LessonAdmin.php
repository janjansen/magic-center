<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class LessonAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
//            ->add('filename')
            ->add('title', null, ['label' => 'Название'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('cost', null, ['label' => 'Цена'])
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
//            ->add('filename')
            ->add('title', null, ['label' => 'Название'])
//            ->add('description')
            ->add('cost', null, ['label' => 'Цена'])
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
        $lesson = $this->getSubject();

        $options = ['required' => false, 'label' => 'Изображение'];
        if ($lesson && $lesson->getWebPath()) {
            $options['help'] = '<img src="'.$lesson->getWebPath().'" class="admin-preview" />';
        }

        $formMapper
            ->add('file', 'file', $options)
            ->add('title', null, ['label' => 'Название'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('cost', null, ['label' => 'Цена'])
            ->add('isHidden', 'choice', ['choices' => ['No'=>0, "Yes"=>1],'label' => 'Скрыт'])

        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('delete');
        $collection->remove('export');
    }
}
