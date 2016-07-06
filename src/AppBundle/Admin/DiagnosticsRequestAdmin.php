<?php
/**
 * Created by PhpStorm.
 * User: ROSomkin
 * Date: 06.07.2016
 * Time: 10:30
 */


namespace AppBundle\Admin;

use AppBundle\Entity\DiagnosticsRequest;
use AppBundle\Entity\LessonRequest;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class DiagnosticsRequestAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
//            ->add('filename')
            ->add('answer1', null, ['label' => 'ответ 1'])
            ->add('answer2', null, ['label' => 'ответ 2'])
            ->add('answer3', null, ['label' => 'ответ 3'])
            ->add('answer4', null, ['label' => 'ответ 4'])
            ->add('answer5', null, ['label' => 'ответ 5'])
            ->add('answer6', null, ['label' => 'ответ 6'])
            ->add('answer7', null, ['label' => 'ответ 7'])
            ->add('answer8', null, ['label' => 'ответ 8'])
            ->add('status', 'doctrine_orm_string', ['label' => 'Статус'], 'choice', ['choices' => array_flip(DiagnosticsRequest::getStatusesForAdminView())])
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
            ->add('answer1', null, ['label' => 'ответ 1'])
            ->add('answer2', null, ['label' => 'ответ 2'])
            ->add('answer3', null, ['label' => 'ответ 3'])
            ->add('answer4', null, ['label' => 'ответ 4'])
            ->add('answer5', null, ['label' => 'ответ 5'])
            ->add('answer6', null, ['label' => 'ответ 6'])
            ->add('answer7', null, ['label' => 'ответ 7'])
            ->add('answer8', null, ['label' => 'ответ 8'])
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
            ->add('answer1', null, ['label' => 'ответ 1'])
            ->add('answer2', null, ['label' => 'ответ 2'])
            ->add('answer3', null, ['label' => 'ответ 3'])
            ->add('answer4', null, ['label' => 'ответ 4'])
            ->add('answer5', null, ['label' => 'ответ 5'])
            ->add('answer6', null, ['label' => 'ответ 6'])
            ->add('answer7', null, ['label' => 'ответ 7'])
            ->add('answer8', null, ['label' => 'ответ 8'])
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

