<?php

namespace MD\MeditecBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RadiologieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('visible', CheckboxType::class, array('required'  => false))
                ->add('alt', TextType::class)
                ->add('file', FileType::class, array('required'  => false))
                ->add('titre', TextType::class)
                ->add('text', TextareaType::class)
                ->add('icone1', TextType::class)
                ->add('titre1', TextType::class)
                ->add('text1', TextareaType::class)
                ->add('icone2', TextType::class)
                ->add('titre2', TextType::class)
                ->add('text2', TextareaType::class)
                ->add('icone3', TextType::class)
                ->add('titre3', TextType::class)
                ->add('text3', TextareaType::class)
                ->add('icone4', TextType::class)
                ->add('titre4', TextType::class)
                ->add('text4', TextareaType::class)
                
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MD\MeditecBundle\Entity\Radiologie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'md_meditecbundle_radiologie';
    }
}
