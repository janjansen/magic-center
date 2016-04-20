<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/offer")
     */
    public function offerAction(Request $request)
    {
        return $this->render('default/offer.html.twig');
    }

    /**
     * @Route("/masters")
     */
    public function mastersAction()
    {
        $masters = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Employee')
            ->findBy(['isHidden' => 0], ['id' => 'desc']);
        return $this->render('default/masters.html.twig', ['masters' => $masters]);
    }

    /**
     * @Route("/comments")
     */
    public function commentsAction()
    {
        $comments = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Comment')
            ->findBy(['isHidden' => 0], ['id' => 'desc']);
        return $this->render('default/comments.html.twig', ['comments' => $comments]);
    }

    /**
     * @Route("/comments/create")
     * @Method("POST")
     * @param Request $request
     * @return RedirectResponse
     */
    public function createCommentAction(Request $request)
    {
        $bag = $this->get('session')->getFlashBag();
        $v = $this->get('validator');
        $person = $request->get('person');
        $text = $request->get('text');

        $pe = $v->validate($person, [ new Length(['max' => 250]), new NotBlank()]);
        $te = $v->validate($text, [ new Length(['max' => 5000]), new NotBlank()]);

        if(count($pe) || count($te)) {
            foreach($pe as $e) {
                $bag->add('comment_error', $e->getMessage());
            }
            foreach($te as $e) {
                $bag->add('comment_error', $e->getMessage());
            }

            return new RedirectResponse('/comments');
        } else {
            $comment = new Comment();
            $comment->setIsHidden(1);
            $comment->setPerson($person);
            $comment->setText($text);
            $em = $this->get('doctrine.orm.default_entity_manager');
            $em->persist($comment);
            $em->flush();

            $bag->set('comment_success', 'Ваш комментарий появится на сайте после модерации');
        }

        return new RedirectResponse('/comments');
    }
}
