<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Repository\ConversationRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConversationController extends AbstractController
{
    private $conversationRepository;
    private $utilisateurRepository;
    function __construct(ConversationRepository $conversationRepository,UtilisateurRepository $utilisateurRepository)
    {
        $this->conversationRepository = $conversationRepository;
        $this->utilisateurRepository=$utilisateurRepository;
    }

    /**
     * @Route("/conversations", name="conversations")
     */
    public function converser()
    {
        $conversations=$this->conversationRepository->findAll();
        return $this->render('conversation/conversations.html.twig', [
            'conversations' => $conversations
        ]);
    }
    /**
     * @Route("/conversations/{id}", name="conversations.details")
     */
    public function discussion(Conversation $conversation,Request $request, int $id)
    {

        return $this->render('conversation/discuss.html.twig', [
            'conversation' => $conversation
        ]);
    }
    /**
     * @Route("/conversations/{id}/ajoutMessage", name="conversations.ajout.message",methods={"post"})
     */
    public function ajoutMessage(Request $request, int $id)
    {
        $conversation = $this->conversationRepository->find($id);

        ;
        $user = $this->getUser();
            $m=trim($request->request->get('message'));
            if(empty($m))
            {
                $this->get('session')->getFlashBag()->set('error',"entrez votre commentaire");
            }
            else
                {
                    $message=new Message();
                    $message->setContenu($m);
                    $message->setUtilisateur($user);
                    $message->setConversation($conversation);
                    $message->setDatetime(new \DateTime());
                    //enregistrons le message
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($message);
                    $em->flush();
                    $this->addFlash(
                        'notice',
                        'commentaire ajouté avec succès!');

                }
        return $this->render('conversation/discuss.html.twig', [
            'conversation' => $conversation
        ]);
    }

    /**
     * @Route("/ajoutConversation", name="conversations.ajout",methods={"post"})
     */
    public function ajoutConversation(Request $request)
    {
        $url = $this->generateUrl("conversations");
            $sujet=$request->request->get("sujet");


        if(empty($sujet))
        {
            $this->get('session')->getFlashBag()->set('error',"entrez un sujet");
        }
        else
        {
         $user=$this->getUser();
         $conversation=new Conversation();
         $conversation->setdate(new \DateTime());
         $conversation->setUtilisateur($user);
         $conversation->setSujetConversation($sujet);
         $em = $this->getDoctrine()->getManager();
         $em->persist($conversation);
         $em->flush();
           $this->addFlash(
               'notice',
                'conversation ajoutée avec succès!');

        }
        return new RedirectResponse($url);
    }
}
