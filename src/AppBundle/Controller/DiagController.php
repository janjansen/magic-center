<?php
/**
 * Created by PhpStorm.
 * User: ROSomkin
 * Date: 06.07.2016
 * Time: 10:47
 */

namespace AppBundle\Controller;

use AppBundle\Entity\DiagnosticsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DiagController extends Controller
{

    /**
     * @Route("/diagnostics")
     * @param Request $request
     * @return RedirectResponse
     */
    public function showFormAction(Request $request)
    {
        return $this->render('diagnostics/request.html.twig', [
            'cost' => $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'DIAGNOSTICS_COST']),
            'content' => $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'DIAGNOSTICS_PAGE']),
        ]);
    }

    /**
     * @Route("/diagnostics/create")
     * @param Request $request
     * @return RedirectResponse
     */
    public function createRequestAction(Request $request)
    {
        $data = $this->getDiagRequestData($request->get('d'));

        if ($data == false) {
            return new RedirectResponse('/diagnostics');
        }

        $file = $request->files->get('photo');

        if (!$file) {
            $this->get('session')->getFlashBag()->set('d_request_error', 'Не загружена фотография');
            return new RedirectResponse('/diagnostics');
        }

        /**
         * @var $file UploadedFile
         */
        if (!in_array($file->getMimeType(), ['jpg' => 'image/jpeg','png' => 'image/png','gif' => 'image/gif',])) {
            $this->get('session')->getFlashBag()->set('d_request_error', 'Некорректный файл');
            return new RedirectResponse('/diagnostics');
        }

        $r = $this->createDiagRequest($data, $file);

        return $this->render(
            'diagnostics/go_to_payment.html.twig',
            [
                'r' => $r,
                'cost' => $this->getDoctrine()->getRepository('AppBundle:Content')->findOneBy(['key' => 'DIAGNOSTICS_COST']),
                'ya_scid' => $this->container->getParameter('ya_scid'),
                'ya_shop_id'  => $this->container->getParameter('ya_shop_id'),
            ]
        );
    }

    protected function createDiagRequest(array $data, UploadedFile $file)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $r = new DiagnosticsRequest();
        $r->setAnswer1($data['answer1']);
        $r->setAnswer2($data['answer2']);
        $r->setAnswer3($data['answer3']);
        $r->setAnswer4($data['answer4']);
        $r->setAnswer5($data['answer5']);
        $r->setAnswer6($data['answer6']);
        $r->setAnswer7($data['answer7']);
        $r->setAnswer8($data['answer8']);
        $r->setFile($file);
        $r->setStatus(DiagnosticsRequest::STATUS_CREATED);

        $em->persist($r);
        $em->flush();

        return $r;
    }

    protected function getDiagRequestData($data)
    {
        $flashes = $this->get('session')->getFlashBag();
        $v = $this->get('validator');

        for ($i = 1; $i < 9; $i++) {
            if (count($v->validate(@$data['answer'.$i], [new Assert\NotBlank(), new Assert\NotNull()]))) {
                $flashes->set('d_request_error', "Не заполнено одно из полей");
                return false;
            }
        }

        return $data;
    }

}