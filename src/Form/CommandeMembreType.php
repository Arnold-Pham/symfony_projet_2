<?php

namespace App\Form;


use DateTime;
use DateTimeZone;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class CommandeMembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_heure_depart', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new DateTime('tomorrow', new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i')
                ]
            ])
            ->add('date_heure_fin', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new DateTime('tomorrow', new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i')
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
