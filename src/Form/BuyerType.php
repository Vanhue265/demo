<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\Buyer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BuyerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('buyername', TextType::class,
            [
                'label'=> 'Name of Buyer'
            ])
            ->add('buyerphone', TextType::class,
            [
                'label'=> 'PhoneNumber'
            ])
            ->add('buyeraddress', TextType::class,
            [
                'label'=> 'Address'
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
            'data_class' => Buyer::class,
        ]);
    }
}
