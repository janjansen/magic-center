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
            ->add('cost')
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
            ->add('filename')
            ->add('cost')
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
            $options['help'] = '<video  width="320" height="240" controls><source src="'.$lesson->getWebPath().'" type="video/mp4"></video>';
        }

        $formMapper
            ->add('file', 'file', $options)
            ->add('cost')
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
            ->add('filename')
            ->add('isHidden')
        ;
    }
}
