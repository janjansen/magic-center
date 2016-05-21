<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 5/15/2016
 * Time: 19:44
 */


namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{

    /**
     * @Route("/comments")
     */
    public function listAction()
    {
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findBy(['isHidden' => 0]);
        return $this->render('comment/list.html.twig', ['comments' => $comments]);
    }

    /**
     * @Route("/comment/create")
     */
    public function createAction(Request $r)
    {
        $c = new Comment();
        $c->setPerson($r->get('name'));
        $c->setText($r->get('content'));
        $c->setEmail($r->get('email'));
        $c->setIsHidden(0);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($c);
        $em->flush();
        return new RedirectResponse('/comments');
    }
}
