<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use App\Entity\Chats;

class ChatRoutes extends Controller
{
    private $messages = array();

	/**
     * @Route("/guestbook/send-message", methods={"POST"})
     */
	public function sendMessage(Request $request)
	{
        $msg=$this->serializer()->deserialize($request->getContent(), Chats::class, 'json');

        $msg->setTime(new \DateTime());

        $this->getDoctrine()->getManager()->persist($msg)->flush();

        array_push($this->messages, $msg);

        return $this->messagesResponse();
	}
	
	/**
     * @Route("/guestbook/read-messages", methods={"GET"})
     */
	public function readMessages()
	{
        return $this->messagesResponse();
    }

    private function messagesResponse() {
        // AVOID DB DATA LOADING IF ARRAY IS ALREADY SET
        if (empty($this->messages)) {
            $this->messages = $this->getDoctrine()
            ->getRepository(Chats::class)
            ->findAll();
        }

        return new Response((new Serializer([new ObjectNormalizer()], [new JsonEncoder()]))->serialize($this->messages, 'json'));
    }
}





