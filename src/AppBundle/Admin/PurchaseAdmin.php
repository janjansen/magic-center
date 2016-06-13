<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Purchase;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class PurchaseAdmin extends BaseAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('status')
            ->add('deliveryAt')
            ->add('user.id')
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
            ->add('status')
            ->add('phone')
            ->add('deliveryAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'details' => array('template' => 'admin/btns/show_details_btn.html.twig'),
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
            ->add('phone')
            ->add('address')
            ->add('deliveryAt', 'sonata_type_datetime_picker', ['format' => 'yyyy-MM-dd HH:mm'])
            ->add('status', 'choice', ['choices' => array_flip(Purchase::getStatusesForAdminView())])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('status')
            ->add('deliveryAt')
            ->add('phone')
            ->add('address')
            ->add('purchaseProducts')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('details', $this->getRouterIdParameter().'/details');
        $collection->remove('delete');
        $collection->remove('create');
    }
}
