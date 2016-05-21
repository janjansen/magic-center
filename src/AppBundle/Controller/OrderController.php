<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/13/16
 * Time: 11:18 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\PurchaseProduct;
use AppBundle\Entity\Purchase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class OrderController extends Controller
{
    /**
     * @Route("/basket")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBasketAction(Request $request)
    {
        $productIds = json_decode($request->cookies->get('basket'), true);
        if (empty($productIds)) {
            return $this->render(':order:basket_empty.html.twig');    
        }
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findBy(['id' => array_unique($productIds)]);
        foreach ($productIds as $pid) {
            foreach ($products as $p) {
                if ($p->getId() == $pid) {
                    $p->basketQuantity ++;
                }
            }
        }
        $total = array_reduce($products, function ($t,$i) {$t = $t + $i->basketQuantity * $i->getCost(); return $t;}, 0);
        return $this->render(':order:basket.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/order/create")
     *
     * @param Request $request
     * @return Response
     */
    public function createOrderAction(Request $request)
    {
        $products = $this->getProductsToPurchase($request->get('pid'));
        $orderData = $this->getOrderData($request->get('order'));
        if ($products == false || $orderData == false) {
            return new RedirectResponse('/basket');
        }
        $order = $this->createOrder($orderData, $products);

//        $order = $this->getDoctrine()->getRepository('AppBundle:Purchase')->find(1);

        return $this->render(':order:go_to_payment.html.twig', ['order' => $order]);
    }

    protected function getOrderData($data)
    {
        $flashes = $this->get('session')->getFlashBag();
        $v = $this->get('validator');

        if (count($v->validate(@$data['phone'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 10, 'max' => 15])]))) {
            $flashes->set('order_error', "Некорректный номер телефона");
            return false;
        }

        if (count($v->validate(@$data['address'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 1, 'max' => 1000])]))) {
            $flashes->set('order_error', "Некорректный адресс");
            return false;
        }

        return $data;
    }

    protected function createOrder($orderData, $products)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $order = new Purchase();
        $order->setStatus(Purchase::STATUS_PLACED);
        $order->setUser($this->getUser());
        $order->setAddress($orderData['address']);
        $order->setPhone($orderData['phone']);
        $em->persist($order);

        foreach ($products as $p) {
            /**
             * @var $product Product
             */
            $product = $p['product'];

            for ($i = 0; $i < $p['quantity']; $i++) {
                $pp = new PurchaseProduct();
                $pp->setStatus(PurchaseProduct::STATUS_BOOKED);
                $pp->setCost($product->getCost());
                $pp->setProduct($product);
                $pp->setPurchase($order);
                $em->persist($pp);
            }
        }

        $em->flush();

        return $order;
    }

    protected function getProductsToPurchase($rawData)
    {
        $flashes = $this->get('session')->getFlashBag();
        $v = $this->get('validator');
        $constraints = [new Assert\Type(['type' => 'numeric']), new Assert\GreaterThan(0)];
        $result = [];

        foreach ($rawData as $pid => $q) {

            if (count($v->validate($pid, $constraints))) {
                $flashes->set('order_error', "Некорректный ID товара: $pid");
                return false;
            }

            if (count($v->validate($q, $constraints))) {
                $flashes->set('order_error', "Некорректное количество товара: $q");
                return false;
            }

            $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($pid);

            if (!$product) {
                $flashes->set('order_error', "Товар с ID $pid не существует");
                return false;
            }

            $result[] = [
                'product' => $product,
                'quantity' => $q,
            ];
        }

        return $result;
    }
}