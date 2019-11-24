<?php

namespace SiteAPE\PlateformeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use SiteAPE\PlateformeBundle\Form\ImageType;


class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateType::class)->add('titre', TextType::class)->add('auteur', TextType::class)->add('contenu', TextareaType::class)->add('publication', CheckboxType::class, array('required'=>false))->add('sauvegarde', SubmitType::class)->add('image', ImageType::class)->add('categories', EntityType::class, 
        array('class'=>'SiteAPEPlateformeBundle:Categorie','choice_label'=>'nom','multiple'=>true));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteAPE\PlateformeBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'siteape_plateformebundle_annonce';
    }


}
