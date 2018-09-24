<?php
/**
 * Created by PhpStorm.
 * User: MicPiwo
 * Date: 15/09/2018
 * Time: 12:41
 */

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm ( $builder, $options );
        $builder
            ->add ('email', EmailType::class)
            ->add ('username', TextType::class)
            ->add ('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Votre mot de passe'),
                'second_options' => array('label' => 'Merci de répéter votre mot de passe')
            ])
        ->add ('Accepter_les_conditions_du_site', CheckboxType::class,[
            'mapped' => false,
            'constraints' => new IsTrue(),
        ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions ( $resolver );
        $resolver->setDefaults (array (
            'data_class' => User::class,
        ));
    }
}