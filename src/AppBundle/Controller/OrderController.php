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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class OrderController extends Controller
{

    /**
     * @Route("/basket/add")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addBasketAction(Request $request)
    {
        $basket = explode(',',$request->cookies->get('basket'));
        $pid = $request->get('pid');
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($pid);
        if (!$product) {
            throw new HttpException(404);
        }
        /**
         * @var Product $product
         */
        $product->setReservedTill(new \DateTime("+1 day"));
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();
        $basket[] = $pid;
        $cookie = new Cookie('basket', implode(',',array_unique($basket)));
        $response = new RedirectResponse('/basket');;
        $response->headers->setCookie($cookie);
        return $response;
    }

    /**
     * @Route("/basket")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBasketAction(Request $request)
    {
        if (empty($request->cookies->get('basket'))) {
            return $this->render(':order:basket_empty.html.twig');
        }
        $productIds = explode(',',$request->cookies->get('basket'));
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findBy(['id' => array_unique($productIds)]);
        $total = array_reduce($products, function ($t,$i) {$t = $t + $i->getCost(); return $t;}, 0);

        return $this->render(
            ':order:basket.html.twig',
            [
                'products' => $products,
                'total' => $total,
                'prev' => $this->getPrevData(),
                'basketCount' => count(explode(',', $request->cookies->get('basket'))),
            ]
        );
    }

    /**
     * @Route("/basket/delete")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteBasketAction(Request $request)
    {
        $basket = explode(',',$request->cookies->get('basket'));
        $pid = $request->get('pid');
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($pid);
        if (!$product) {
            throw new HttpException(404);
        }
        /**
         * @var Product $product
         */
        $product->setReservedTill(new \DateTime("now"));
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();
        $nb = [];
        foreach ($basket as &$v) {
            if ($v != $pid) {
                $nb[] = $v;
            }
        }
        $cookie = new Cookie('basket', implode(',',array_unique($nb)));
        $response = new RedirectResponse('/basket');;
        $response->headers->setCookie($cookie);
        return $response;
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
            $this->get('session')->getFlashBag()->set('order_data', json_encode($request->get('order')));
            return new RedirectResponse('/basket');
        }
        $order = $this->createOrder($orderData, $products);

//        $order = $this->getDoctrine()->getRepository('AppBundle:Purchase')->find(1);

        $this->getDoctrine()->getEntityManager()->refresh($order);
        $cookie = new Cookie('basket', '');
        $response = new Response();
        $response->headers->setCookie($cookie);
        $response->setContent($this->container->get('twig')->render(':order:go_to_payment.html.twig', ['order' => $order]));
        return $response;
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

        if (count($v->validate(@$data['email'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Email(), new Assert\Length(['min' => 1, 'max' => 255])]))) {
            $flashes->set('order_error', "Некорректный email");
            return false;
        }

        if (count($v->validate(@$data['lname'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 1, 'max' => 1000])]))) {
            $flashes->set('order_error', "Некорректная фамилия");
            return false;
        }

        if (count($v->validate(@$data['fname'], [new Assert\NotBlank(), new Assert\NotNull(), new Assert\Length(['min' => 1, 'max' => 1000])]))) {
            $flashes->set('order_error', "Некорректное имя");
            return false;
        }

        return $data;
    }

    protected function createOrder($orderData, $products)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $order = new Purchase();
        $order->setStatus(Purchase::STATUS_PLACED);
        $order->setAddress($orderData['address']);
        $order->setPhone($orderData['phone']);
        $order->setEmail($orderData['email']);
        $order->setCity($orderData['city']);
        $order->setComment($orderData['comment']);
        $order->setCountry($orderData['country']);
        $order->setFname($orderData['fname']);
        $order->setLname($orderData['lname']);
        $order->setPindex($orderData['pindex']);
        $em->persist($order);

        foreach ($products as $p) {
            /**
             * @var $product Product
             */
            $product = $p['product'];

            $pp = new PurchaseProduct();
            $pp->setStatus(PurchaseProduct::STATUS_BOOKED);
            $pp->setCost($product->getCost());
            $pp->setProduct($product);
            $pp->setPurchase($order);
            $em->persist($pp);
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

        foreach ($rawData as $pid) {

            if (count($v->validate($pid, $constraints))) {
                $flashes->set('order_error', "Некорректный ID товара: $pid");
                return false;
            }

            $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($pid);

            if (!$product) {
                $flashes->set('order_error', "Товар с ID $pid не существует");
                return false;
            }

            $result[] = [
                'product' => $product,
                'quantity' => 1,
            ];
        }

        return $result;
    }

    protected function getPrevData()
    {
        $flashes = $this->get('session')->getFlashBag()->get('order_data');
        $prevData = isset($flashes[0]) ? json_decode($flashes[0], true) : [];
        return  array_merge(
            ['fname' => '','lname' => '', 'phone' => '', 'city' => '', 'email' => '', 'address' => '', 'comment' => '', 'pindex' => '', 'country' => ''],
            $prevData ?: []
        );
    }
}