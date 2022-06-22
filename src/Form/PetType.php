<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\Buyer;
use App\Entity\Staff;
use App\Entity\Receipt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('petname', TextType::class,
            [
                'label' => 'Name of Pet'
            ])
            ->add('petgender', ChoiceType::class,
            [
                'label' => 'Gender of Pet',
                'required' => true,
                'choices' => [
                    "Male" => "Male",
                    "Female" => "Female",                        
                ],
                'multiple' => false,
                'expanded' => true
                ])
            ->add('pettype', TextType::class,
            [
                'label' => 'Type of Pet'
            ])
            ->add('petimage', FileType::class,
            [
                'label' => 'Pet image',
                'data_class' => null,
                'required' => is_null($builder->getData()->getPetimage())                       
            ])
            ->add('buyer', EntityType::class,
            [
                'label' => 'Buyer name',
                'required' => true,
                'class' => Buyer::class,
                'choice_label' => 'buyername',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('receipt', EntityType::class,
            [
                'label' => 'Receipt',
                'required' => true,
                'class' => Receipt::class,
                'choice_label' => 'id',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('staffs', EntityType::class,
            [
                'label' => 'Staff name',
                'required' => true,
                'class' => Staff::class,
                'choice_label' => 'staffname',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }
}
