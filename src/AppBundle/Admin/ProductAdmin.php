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
            ->add('name', null, ['label' => 'Название'])
            ->add('cost', null, ['label' => 'Цена'])
            ->add('category', null, ['label' => 'Категория товара'])
            ->add('isHidden', 'doctrine_orm_number', ['label' => 'Скрыт'], 'choice', ['label' => 'Скрыт','choices' => ['No'=>0, "Yes"=>1]])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', null, ['label' => 'Название'])
            ->add('cost', null, ['label' => 'Цена'])
            ->add('category', null, ['label' => 'Категория товара'])
            ->add('reservedTill', null, ['label' => 'Зарезервирован до'])
            ->add('isHidden', 'boolean', ['label' => 'Скрыт'])
            ->add('checkIsVisiable', 'boolean', ['label' => 'Отбражается на сайте?'])
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
            ->add('name', null, ['label' => 'Название'])
            ->add('cost', null, ['label' => 'Цена'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('reservedTill', 'sonata_type_datetime_picker', ['label' => 'Зарезервирован до','format' => 'yyyy-MM-dd HH:mm', 'required' => false])
            ->add('category', null, ['label' => 'Категория товара'])
            ->add('isHidden', 'choice', ['choices' => ['No'=>0, "Yes"=>1],'label' => 'Скрыт'])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('details', $this->getRouterIdParameter().'/details');
        $collection->remove('delete');
        $collection->remove('show');
    }

}
