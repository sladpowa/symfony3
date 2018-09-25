<?php
/**
 * Created by PhpStorm.
 * User: MicPiwo
 * Date: 25/09/2018
 * Time: 12:57
 */

namespace AppBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bonne pratique => ContactHandle pour ne pas surcharger le ContactController
 */
class ContactHandler
{
    protected $request;
    protected $formContact;
    protected $mailer;

    /**
     * @param Form $formContact
     * @param Request $request
     * @param $mailer
     */

    public function __construct(Form $formContact, Request $request, $mailer)
    {
        $this->formContact = $formContact;
        $this->request = $request;
        $this->mailer = $mailer;
    }

    public function process(){
        if('POST' == $this->request->getMethod ()){
            $this->formContact->handleRequest ($this->request);
            $data = $this->formContact->getData ();
            $this->onSuccess ($data);
        }
    }

    public function onSuccess($data){

        $message = \Swift_Message::newInstance ()
            ->setContentType ('text/html')
            ->setSubject ('subject')
            ->setFrom ($data->getEmail('email'))
            ->setTo ('micpiwo@hotmail.fr')
            ->setBody ('content');
        $this->mailer->send ($message);

    }
}