<?php

namespace App\Form;

use App\Entity\Oeuvres;
use App\Entity\Artistes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('image')
            ->add('prix')
            ->add('description')
            ->add('artiste', EntityType::class, [
                'class' => Artistes::class,
                    'choice_label' => 'nom',
                    'choice_value' => 'id'
            ])
            ->add('id_user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvres::class,
        ]);
    }
}
