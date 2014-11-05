<?php

namespace Ferus\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom',
            ))
            ->add('date', 'date', array(
                'label' => 'Date',
            ))
            ->add('maxTickets', 'integer', array(
                'label' => 'Nombre de participants',
            ))
            ->add('askForCars', 'choice', array(
                'label' => 'Demande de parking',
                'choices' => array(
                    'Non',
                    'Activé'
                ),
                'attr' => array(
                    'help_text' => 'Activer pour que les participants puissent faire une demande pour garer leur voiture dans l\'école pendant l\'événement',
                ),
            ))
            ->add('tickets', 'collection', array(
                'type' => new TicketType(),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ))
            ->add('actions', 'form_actions', [
                'buttons' => array(
                    'save' => [
                        'type' => 'submit',
                        'options' => [
                            'label' => 'Enregistrer',
                        ]
                    ],
                )
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ferus\EventBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ferus_eventbundle_event';
    }
}
