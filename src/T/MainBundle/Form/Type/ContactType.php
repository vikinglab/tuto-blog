<?php

namespace T\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('nom')
            ->add('prenom')
            ->add('sujet')
            ->add('contenu', 'textarea')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                // ici nous indiquons la class Contact doit utiliser
                'data_class' => 'T\MainBundle\Form\Data\Contact',
            )
        );
    }

    public function getName()
    {
        return 'contact';
    }
}
