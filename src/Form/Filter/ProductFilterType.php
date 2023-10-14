<?php
declare(strict_types=1);

namespace App\Form\Filter;

use App\DTO\ProductDto;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public  function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setMethod('GET')
            ->add('title', TextType::class, [
                'required' => false,
            ])
            ->add('price', NumberType::class, [
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('image', TextType::class, [
                'required' => false,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => ProductDto::class,
        ]); 
    }
}