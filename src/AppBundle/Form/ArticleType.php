<?php

namespace AppBundle\Form;
use AppBundle\AppBundle;
use AppBundle\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
// Hidden type class
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Tests\Fixtures\Entity;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
                ->add('content', CKEditorType::class, array('label' => 'Publier', 'attr' => array(
                    'class' => 'form-control'
                )))
                ->add('save', SubmitType::class, array('label' => 'Publier', 'attr' => array(
                    'class' => 'btn btn-primary'
                )));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
