<?php

namespace App\Form;


use App\Entity\Tags;
use App\Entity\Annoucement;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnoucementType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => "Titre de l'annonce",
                'attr' => [
                    'placeholder' => "Intitulé du poste ..."
                ]
            ] )
            ->add('sector', TextType::class, [
                'required' => true, 
                'label' => "Localisation",
                'attr' => [
                    'placeholder' => "PARIS (75)..."
                ]
            ])
            ->add('salary',TextType::class, [
                'required' => true,
                'label' => "Salaire", 
                'attr' => [
                    'placeholder' => "33000 annuel"
                ]
            ])
            ->add('contract_type', ChoiceType::class, [
                'choices'  => [
                    'stage' => "STAGE",
                    'apprentissage' => "APPRENTISSAGE",
                    'professionnalisation' => "PROFESSIONNALISATION",
                ]])
            ->add('description',TextType::class, [
                'required' => true, 
                'attr' => [
                    'placeholder' => "Description du poste proposé"
                ]
            ])
            ->add('tags', EntityType::class, [
                'class' => Tags::class,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annoucement::class,
        ]);
    }
}
