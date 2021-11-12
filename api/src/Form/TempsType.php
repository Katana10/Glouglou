<?php
/**
 * Formulaire de la Class Temps
 * 
 *  Il est chargé d'organiser le formulaire de la Class Temps lorsqu'on l'appelle
 *  Que ce soit pour une modification ou pour une création
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Form;

use App\Entity\Temps;
use App\Entity\Profondeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TempsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //l'EntityType sert pour les relations ici on appelle la Profondeur pour l'associée
        //le choice label avec les paramètre multiple => false et expanded => false correspond a un select en html
        $builder
            ->add('temps', NumberType::Class)
            ->add('palier15', NumberType::Class,['required' => false])
            ->add('palier12', NumberType::Class,['required' => false])
            ->add('palier9', NumberType::Class,['required' => false])
            ->add('palier6', NumberType::Class,['required' => false])
            ->add('palier3', NumberType::Class,['required' => false])
            ->add('est_a', EntityType::Class, [
                'class' => Profondeur::Class,
                'choice_label' => function ($profondeur) {
                    return $profondeur->getProfondeur();
                },
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Temps::class,
        ]);
    }
}
