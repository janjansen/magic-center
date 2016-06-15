<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ProductAdmin extends BaseAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('cost')
            ->add('category')
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
            ->add('name')
            ->add('cost')
            ->add('category')
            ->add('reservedTill')
            ->add('isHidden', 'boolean')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'details' => array('template' => 'admin/btns/show_details_btn.html.twig'),
//                    'show' => array(),
//                    'edit' => array(),
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
            ->add('name')
            ->add('cost')
            ->add('description')
            ->add('reservedTill', 'sonata_type_datetime_picker', ['format' => 'yyyy-MM-dd HH:mm', 'required' => false])
            ->add('category')
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
            ->add('name')
            ->add('description')
            ->add('images')
            ->add('isHidden')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('details', $this->getRouterIdParameter().'/details');
        $collection->remove('delete');
        $collection->remove('show');
    }

}
