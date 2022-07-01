<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('staffname', TextType:: class,
            [
                'label' => 'Name of Staff'
            ])
            ->add('staffphone', TextType::class,
            [
                'label' => 'PhoneNumber'
            ])
            ->add('staffaddress', TextType:: class,
            [
                'label' => 'Address'
            ])
            ->add('pets', EntityType::class,
            [
                'label' => 'Pet name',
                'required' => true,
                'class' => Pet::class,
                'choice_label' => 'petname',
                'multiple' => true,
                'expanded' => false
            ])
            -> add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}