<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tools;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ToolsController extends Controller
{
    /**
     * @Route("/outils", name="tools_show")
     */
    public function showAction(){

        $tools = $this->getDoctrine ()
            ->getRepository (Tools::class)->findAll ();

        return $this->render ('tools/tools.html.twig',[
            'tools' => $tools
        ]);
    }

    /**
     * @Route("outils/{id}", name="tools_by_id")
     */
    public function toolsIdAction(Tools $tools){

        return $this->render ('tools/toolsId.html.twig', [
            'tools' => $tools
        ]);
    }
}
