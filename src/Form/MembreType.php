<?php

namespace App\Form;


use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $sexe = ['Homme' => 'M', 'Femme' => 'F'];
        $statut = ['Membre' => 0, 'Admin' => 1];

        $builder
            ->add('nom', null, [
                'label' => '<i class="bi bi-pencil-fill"></i>',
                'label_html' => true,
                'row_attr' => ['class' => 'mb-3 input-group'],
                'attr' => ['placeholder' => 'Saisir Nom']
            ])
            ->add('prenom', null, [
                'label' => '<i class="bi bi-pencil-fill"></i>',
                'label_html' => true,
                'row_attr' => ['class' => 'mb-3 input-group'],
                'attr' => ['placeholder' => 'Saisir Prénom']
            ])
            ->add('email', null, [
                'label' => '<i class="bi bi-envelope-fill"></i>',
                'label_html' => true,
                'row_attr' => ['class' => 'mb-3 input-group'],
                'attr' => ['placeholder' => 'email@exemple.com']
            ])
            ->add('pseudo', null, [
                'label' => '<i class="bi bi-person-fill"></i>',
                'label_html' => true,
                'row_attr' => ['class' => 'mb-3 input-group'],
                'attr' => ['placeholder' => 'Saisir Pseudo']
            ])
            ->add('password', PasswordType::class, [
                'label' => '<i class="bi bi-lock-fill"></i>',
                'label_html' => true,
                'row_attr' => ['class' => 'mb-3 input-group'],
                'attr' => ['placeholder' => '●●●●●●●●●●', 'autocomplete' => 'new-password'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a password']),
                    new Length(['min' => 6, 'max' => 4096]),
                ],
            ])
            ->add('civilite', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => $sexe,
                'row_attr' => ['class' => 'mb-3 input-group'],
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => $statut,
                'row_attr' => ['class' => 'mb-3 input-group'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
