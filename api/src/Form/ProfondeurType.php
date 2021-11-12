<?php
/**
 * Formulaire de la Class Profondeur
 * 
 *  Il est chargé d'organiser le formulaire de la Class Profondeur lorsqu'on l'appelle
 *  Que ce soit pour une modification ou pour une création
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Form;

use App\Entity\Profondeur;
use App\Entity\TablePlongee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfondeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //l'EntityType sert pour les relations ici on appelle la Table plongee pour l'associée
        //le choice label avec les paramètre multiple => false et expanded => false correspond a un select en html
        $builder
            ->add('profondeur', NumberType::Class)
            ->add('table_associee', EntityType::Class, [
                'class' => TablePlongee::Class,
                'choice_label' => function ($table) {
                    return $table->getNom();
                },
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profondeur::class,
        ]);
    }
}
