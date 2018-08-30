<?php

namespace App\Form;

use App\Entity\MP3Metadata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MP3MetadataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('artist')
            ->add('album')
            ->add('duration')
            ->add('year')
            ->add('genre')
            ->add('comment')
            ->add('contributor')
            ->add('bitrate')
            ->add('track')
            ->add('popularityMeter')
            ->add('uniqueFileIdentifier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MP3Metadata::class,
        ]);
    }
}
