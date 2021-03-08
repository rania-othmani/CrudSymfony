<?php

namespace App\Form;

use App\Entity\Classroom;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name'/*, TextType::class, [
                'label'=>'Nom Classroom',
                'attr'=>[
                    'placeholder'=>'Merci de definir le nom',
                    'class'=>'name'
                ]]*/); //<input type=text>

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
