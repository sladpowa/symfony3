<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use AppBundle\Form\Handler\ContactHandler;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/validation_contact", name="valid_contact")
     */
    public function validContactAction(){

        return $this->render ('contact/valideContact.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contact", name="contact_form")
     */
    public function contactAction(Request $request, ObjectManager $manager){
        $message = new Contact();
        $formContact = $this->createForm (ContactType::class, $message);

        //Récuperation du Handler => dossier Form
        $formHandler = new ContactHandler($formContact, $request, $this->get('mailer'));
        $process = $formHandler->process ();

        if($process){
            $this->get('session')->setFlash('Administrateur', 'Merci de votre prise de contact
            , une réponse vous sera rapidement expédiée.');

        }

        return $this->render ('contact/contact.html.twig',[
            'message' => $message,
            'formContact' => $formContact->createView (),
            'hasError' => $request->getMethod () == 'POST' && !$formContact->isValid ()
        ]);
    }
}
