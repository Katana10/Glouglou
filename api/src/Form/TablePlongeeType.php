<?php
/**
 * Formulaire de la Class TablePlongee
 * 
 *  Il est chargé d'organiser le formulaire de la Class TablePlongee lorsqu'on l'appelle
 *  Que ce soit pour une modification ou pour une création
 * 
 * @author TALIBART Killian
 * @version 7.4.10
 * 
 */
namespace App\Form;

use App\Entity\TablePlongee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TablePlongeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::Class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TablePlongee::class,
        ]);
    }
}
