<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\ContactMessageRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/messages")
 */
class ContactMessageController extends AbstractController
{
    /**
     * @Route("/", name="contact_message_index", methods={"GET"})
     * @param ContactMessageRepository $contactMessageRepository
     * @return Response
     */
    public function index(ContactMessageRepository $contactMessageRepository): Response
    {
        return $this->render('contact_message/index.html.twig', [
            'contact_messages' => $contactMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contact_message_new", methods={"GET","POST"})
     * @param Request $request
     * @param LoggerInterface $logger
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function new(Request $request, LoggerInterface $logger, \Swift_Mailer $mailer): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);
        $contactMessage->setFromIp($request->getClientIp());
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactMessage);
            $entityManager->flush();
            try{
                $ip = $request->getClientIp();
                $_time = new \DateTime();
                $message = (new \Swift_Message('New message from ['.$contactMessage->getFromName().'] at ' . $_time->format('Y-m-d H:i:s')))
                    ->setFrom('hicam.golda@gmail.com')
                    ->setTo('lolnik@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'contact_message/email.html.twig',
                            [
                                'contactMessage' => $contactMessage
                            ]
                        ),
                        'text/html'
                    );
                $res = $mailer->send($message);
            } catch (\Throwable $ex) {
                $logger->critical($ex->getMessage());
            }
            return $this->redirectToRoute('public_main_page');
        }

        return $this->render('contact_message/new.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new_from_main_page", name="new_from_main_page", methods={"POST"})
     * @param Request $request
     * @param LoggerInterface $logger
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function newFromMainPage(Request $request, LoggerInterface $logger, \Swift_Mailer $mailer): Response
    {
        $data = $request->request->all();

        $contactMessage = new ContactMessage();
        $ip = $request->getClientIp();
        $contactMessage->setFromIp($ip);
        $contactMessage->setFromName($data['fromName']);
        $contactMessage->setFromPhoneNumber($data['fromPhoneNumber']);
        $contactMessage->setFromEmail($data['fromEmail']);
        $contactMessage->setMessage($data['message']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contactMessage);
        $entityManager->flush();
        try{

            $_time = new \DateTime();
            $message = (new \Swift_Message('New message from ['.$contactMessage->getFromName().'] at ' . $_time->format('Y-m-d H:i:s')))
                ->setFrom('hicam.golda@gmail.com', 'L.M.Pitronot [New message from '. $contactMessage->getFromName() . ']')
                ->setTo(['lolnik@gmail.com', 'milena.mihlev@gmail.com' => 'Milena', 'krolleon@gmail.com' => 'Leonid'])
                ->setBody(
                    $this->renderView(
                        'contact_message/email.html.twig',
                        [
                            'contactMessage' => $contactMessage
                        ]
                    ),
                    'text/html'
                );
            $res = $mailer->send($message);
        } catch (\Throwable $ex) {
            $logger->critical($ex->getMessage());
        }
        return $this->redirectToRoute('public_main_page');
;
    }

    /**
     * @Route("/{id}", name="contact_message_show", methods={"GET"})
     * @param ContactMessage $contactMessage
     * @return Response
     */
    public function show(ContactMessage $contactMessage): Response
    {
        return $this->render('contact_message/show.html.twig', [
            'contact_message' => $contactMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_message_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ContactMessage $contactMessage
     * @return Response
     */
    public function edit(Request $request, ContactMessage $contactMessage): Response
    {
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_message_index');
        }

        return $this->render('contact_message/edit.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ContactMessage $contactMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contactMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_message_index');
    }
}
