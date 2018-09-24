<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Test;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UploadedFile;

class TestController extends Controller
{
    /**
     * @Route("test", name="test")
     */
    public function showTestAction(){
        $tests = $this->getDoctrine ()
            ->getRepository (Test::class)->findAll ();
        return $this->render ('test/test.html.twig',[
            'tests' => $tests
        ]);
    }


    /**
     * @Route("/formulaireTest", name="test_form")
     */
    public function formSelectAction(Request $request, ObjectManager $manager){
        $test = new Test();

        $formTest = $this->createFormBuilder ($test)
            ->add ('name')
            ->add ('email')
            ->add ('postal_code')
            ->add ('address')
            ->add ('phone_number')
            ->add ('gender', ChoiceType::class,array(
                'choices' => array(
                    'M' => true,
                    'Mme' => false,
                ),

            ))
            ->getForm ();

        $formTest->handleRequest ($request);
        $id = $test->getId ();
        if($formTest->isSubmitted () && $formTest->isValid ()){
            $manager->persist ($test);
            $manager->flush ();

            return $this->redirectToRoute ('test_id',[
                'id' => $id,
                'test' => $test
            ]);
        }

    return $this->render ('test/testForm.html.twig',[
        'formTest' => $formTest
    ]);


    }

    /**
     * @Route("test/{id}", name="test_id")
     */

    public function testById(Test $test){
        return $this->render ('test/testId.html.twig',[
            'test' => $test
        ]);
    }
}
