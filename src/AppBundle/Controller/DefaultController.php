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
            'news' => $this->getDoctrine()->getRepository('AppBundle:News')->findBy(['isHidden' => 0], ['id' => 'DESC'], 5),
            'content' => $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'FRONT_PAGE']),
        ]);
    }

    /**
     * @Route("/offer")
     */
    public function offerAction(Request $request)
    {
        $offer = $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'OFFER_PAGE']);
        return $this->render('default/offer.html.twig', ['offer' => $offer]);
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
     * @Route("/master/{id}")
     */
    public function mastersGetByIdAction($id)
    {
        $master = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Employee')
            ->findOneBy(['isHidden' => 0,'id' => $id]);
        return $this->render('default/master_view.html.twig', ['master' => $master]);
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
     * @Route("/contacts")
     */
    public function contactsAction()
    {
        $contact = $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'CONTACT_PAGE']);
        return $this->render('default/contacts.html.twig', ['contact' => $contact]);
    }

    /**
     * @Route("/appointment")
     */
    public function requestAction()
    {
        $appointment = $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'APPOINTMENT_PAGE']);
        return $this->render('default/appointment.html.twig', ['appointment' => $appointment]);
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
