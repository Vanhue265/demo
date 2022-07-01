<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\Buyer;
use App\Entity\Receipt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReceiptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('petname', TextType::class,
            [
                'label' => 'Name of Pet'
            ])
            ->add('buyername', TextType::class,
            [
                'label' => 'Name of Buyer'
            ])
            ->add('Price', NumberType::class,
            [
                'label' => 'Price'
            ])
            ->add('datecreate', DateType::class,
            [
                'label' => 'Date Create',
                'widget' => 'single_text'
            ])
            ->add('pet', EntityType::class,
            [
                'label' => 'Pet name',
                'required' => true,
                'class' => Pet::class,
                'choice_label' => 'petname',
                'multiple' => false, 
                'expanded' => false       
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
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Receipt::class,
        ]);
    }
}
