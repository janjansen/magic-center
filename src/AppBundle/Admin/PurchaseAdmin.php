<?php

namespace AppBundle\Admin;

use AppBundle\Entity\LessonRequest;
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
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('lname', null, ['label' => 'Фамилия'])
            ->add('fname', null, ['label' => 'Имя'])
            ->add('email', null, ['label' => 'Email'])
            ->add('city', null, ['label' => 'Город'])
            ->add('deliveryAt', null, ['label' => 'Дата доставки'])
            ->add('status', 'doctrine_orm_number', ['label' => 'Статус'], 'choice', ['choices' => array_flip(Purchase::getStatusesForAdminView())])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('getStatusRusName', null, ['label' => 'Статус'])
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('lname', null, ['label' => 'Фамилия'])
            ->add('fname', null, ['label' => 'Имя'])
            ->add('email', null, ['label' => 'Email'])
            ->add('city', null, ['label' => 'Город'])
            ->add('country', null, ['label' => 'Страна'])
            ->add('deliveryAt', null, ['label' => 'Дата доставки'])
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
            ->add('phone', null, ['label' => 'Телефон'])
            ->add('lname', null, ['label' => 'Фамилия'])
            ->add('fname', null, ['label' => 'Имя'])
            ->add('email', null, ['label' => 'Email'])
            ->add('city', null, ['label' => 'Город'])
            ->add('pindex', null, ['label' => 'Индекс'])
            ->add('country', null, ['label' => 'Страна'])
            ->add('comment', null, ['label' => 'Комментарий'])
            ->add('address', null, ['label' => 'Адрес'])
            ->add('deliveryAt', 'sonata_type_datetime_picker', ['format' => 'yyyy-MM-dd HH:mm', 'required' => false])
            ->add('status', 'choice', ['choices' => array_flip(Purchase::getStatusesForAdminView())])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('details', $this->getRouterIdParameter().'/details');
        $collection->remove('delete');
        $collection->remove('create');
        $collection->remove('show');
    }
}
