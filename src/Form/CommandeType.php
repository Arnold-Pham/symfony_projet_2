<?php

namespace App\Form;


use DateTime;
use DateTimeZone;
use App\Entity\Membre;
use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Twig\FiltreExtension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class CommandeType extends AbstractType
{
    public function __construct(private FiltreExtension $filter)
    {
    }

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
            ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => function ($vehicule) {
                    return $vehicule->getTitre() . " - " . $this->filter->deviseFr($vehicule->getPrixJournalier());
                }
            ])
            ->add('membre', EntityType::class, [
                'class' => Membre::class,
                'choice_label' => function ($membre) {
                    return $membre->getId() . " - " . $membre->getPseudo();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
