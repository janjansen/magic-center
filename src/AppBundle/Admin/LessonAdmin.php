<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
            ->add('filename')
            ->add('title')
            ->add('description')
            ->add('isHidden', 'doctrine_orm_number', [], 'choice', ['choices' => ['No'=>0, "Yes"=>1]])
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
            ->add('title')
//            ->add('description')
            ->add('isHidden', 'boolean')
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

        $options = ['required' => false];
        if ($lesson && $lesson->getWebPath()) {
            $options['help'] = '<img src="'.$lesson->getWebPath().'" class="admin-preview" />';
        }

        $formMapper
            ->add('file', 'file', $options)
            ->add('title')
            ->add('description')
            ->add('isHidden', 'choice', ['choices' => ['No'=>0, "Yes"=>1]])

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('filename')
            ->add('isHidden')
        ;
    }
}
