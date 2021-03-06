<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/16
 * Time: 12:09 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\ProductCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    /**
     * @Route("/category/{id}")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function byCategoryAction(Request $request)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:ProductCategory')->findOneBy(['id' => $request->get('id'), 'isHidden' => 0]);

        if (!$category) {
            throw new NotFoundHttpException;
        }

        return $this->render('product/by_category.html.twig', [
            'category' => $category,
            'basketCount' => count(explode(',', $request->cookies->get('basket')))
        ]);
    }

    /**
     * @Route("/categories")
     */
    public function categoriesListAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:ProductCategory')->findBy(['isHidden' => 0]);
        return $this->render(
            'product/category_list.html.twig',
            [
                'categories' => $categories,
                'basketCount' => count(explode(',', $request->cookies->get('basket')))
            ]
        );
    }

    /**
     * @Route("/product/{id}")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
//    public function productViewAction($id)
//    {
//        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneBy(['id' => $id, 'isHidden' => 0]);
//
//        if (!$product) {
//            throw new NotFoundHttpException;
//        }
//        return $this->render('product/product_view.html.twig', [
//            'product' => $product
//        ]);
//    }
}
