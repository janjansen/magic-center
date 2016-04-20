<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 4:37 PM
 */

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/app/purchase/{id}/details")
     */
    public function detailsPurchaseAction($id)
    {
        return $this->render(':admin:purchase_details.html.twig',
            array_merge(
                $this->getSonataTemplateVars(),
                ['order' => $this->getDoctrine()->getRepository('AppBundle:Purchase')->find($id)]
            )
        );
    }

    /**
     * @Route("/admin/app/product/{id}/details")
     */
    public function detailsProductAction($id)
    {
        return $this->render(':admin:product_details.html.twig',
            array_merge(
                $this->getSonataTemplateVars(),
                ['product' => $this->getDoctrine()->getRepository('AppBundle:Product')->find($id)]
            )
        );
    }


    /**
     * @return array
     */
    protected function getSonataTemplateVars()
    {
        return [
            'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ];
    }
}