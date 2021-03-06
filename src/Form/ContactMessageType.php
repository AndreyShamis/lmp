<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromName')
            ->add('fromPhoneNumber')
            ->add('fromEmail')
            ->add('message')
            ->add('createdAt')
            ->add('updatedAt')
//            ->add('fromIp')
            ->add('label')
            ->add('keepedBy')
            ->add('closed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
