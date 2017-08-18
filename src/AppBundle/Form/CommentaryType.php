<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CommentaryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',null, array(
                'attr' => array(
                    'placeholder'=> 'Entrez votre nom d\'utilisateur ou publié avec un pseudo',
                )
            ))
            ->add('content',null, array(
                'attr' => array(
                    'placeholder'=> 'Entrez votre Message',
                )))



            ->add('article',EntityType::class, array(
                'class'    => 'AppBundle:Article',
                'choice_label' => 'id',
                'label' => ' ',
                'attr' => array(
                    'style'=>'display:none;'

                )));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Commentary'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_commentary';
    }


}
