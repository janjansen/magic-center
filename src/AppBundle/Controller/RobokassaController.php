<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/19/16
 * Time: 2:14 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Purchase;
use AppBundle\Entity\PurchaseProduct;
use AppBundle\Entity\RobokassaResultLog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RobokassaController extends Controller
{
    /**
     * @Route("/robokassa/result")
     */
    public function resultAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $sum = $request->get("OutSum");
        $oid = $request->get("InvId");
        $type = $request->get("shp_type");
        $rsign = strtoupper($request->get("SignatureValue"));
        $pass = $this->getParameter("robokassa_pass2");
        $mysign = strtoupper(md5("$sum:$oid:$pass:shp_type=$type"));

        if ($rsign != $mysign) {
            return $this->handleFailRequest('invalid sing');
        }

        if ($type == Purchase::ROBOKASSA_TYPE) {
            $entity = $em->getRepository('AppBundle:Purchase')->find($oid);
            if (!$entity) {
                return $this->handleFailRequest('invalid InvId');
            }
            $this->markPurchaseAsPaid($entity);
            $this->logRequest();
            $em->flush();
            return new Response("OK{$oid}\n");

        } elseif($type == 's') {
            return $this->handleFailRequest('invalid shp_type');
        } else {
            return $this->handleFailRequest('invalid shp_type');
        }
    }

    /**
     * @Route("/robokassa/success")
     */
    public function successAction(Request $request)
    {
    }

    /**
     * @Route("/robokassa/fail")
     */
    public function failAction(Request $request)
    {
    }

    protected function logRequest($comment = null)
    {
        $rrl = new RobokassaResultLog();
        $rrl->setParams(json_encode($_REQUEST));
        $rrl->setFailComment($comment);

        $this->get('doctrine.orm.default_entity_manager')->persist($rrl);
    }

    protected function handleFailRequest($comment)
    {
        $this->logRequest($comment);
        $this->get('doctrine.orm.default_entity_manager')->flush();
        return new Response("FAIL\n");
    }

    protected function markPurchaseAsPaid(Purchase $purchase)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        foreach($purchase->getPurchaseProducts() as $pp) {
            $pp->setStatus(PurchaseProduct::STATUS_PAID);
            $em->persist($pp);
        }

    }
}
