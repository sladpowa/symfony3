<?php

namespace AppBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Articles;
use AppBundle\Entity\Category;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $articles = $this->getDoctrine ()
            ->getRepository (Articles::class)->findAll ();

        return $this->render ('default/index.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_id")
     */
    public function articleByIdAction(Articles $article){

        return $this->render ('default/articleId.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/creerArticle", name="article_create")
     */
    public function articleCreateAction(Request $request, ObjectManager $manager){

        $newArticle = new Articles();

        $form = $this->createFormBuilder ($newArticle)
            ->add ('title')
            ->add ('content')
            ->add ('image')
            ->getForm ();
        $form->handleRequest ($request);

        if($form->isSubmitted () && $form->isValid ()){
            $newArticle->setCreatedAt (new \DateTime());
            $manager->persist ($newArticle);
            $manager->flush ();
            $id = $newArticle->getId ();
            return $this->redirectToRoute ('article_id',[
                'id' => $id,
                'newArticle' => $newArticle
            ]);

        }

        return $this->render ('default/articleCreate.html.twig', [
            'formArticle' => $form->createView ()
        ]);
    }

    /**
     * @Route("/pdf/{id}", name="article_pdf")
     *
     */

    public function pdfAction(Articles $articles){


        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView ('default/pdf.html.twig',[
            'article' => $articles
        ]);

        $filename = 'articles';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
}
