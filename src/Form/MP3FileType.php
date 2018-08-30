<?php

namespace App\Form;

use App\Entity\MP3File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MP3FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file',FileType::class, array('label' => 'mp3file'));
//            ->add('fullpath')
//            ->add('basename')
//            ->add('mp3Metadata', MP3MetadataType::class)
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MP3File::class
        ]);
    }
}
