<?php

namespace Calm\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', 'email', array('label'=>'E-mail'));
        $builder->add('firstName', 'text', array('label'=>'Nome'));
        $builder->add('lastName', 'text', array('label'=>'Sobrenome'));
        $builder->add('birthday', 'birthday', array('label'=>'Data de Nascimento'));
        $builder->add('gender', 'choice', array('label'=>'Gênero',
            'choices' => array('m' => 'Homem', 'f' => 'Mulher'),
            'required' => true,
            'multiple' => false,
            'expanded' => true,
        ));

        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Os campos de senha devem ser iguais.',
            'options' => array('label' => 'senha', 'trim'=>true),
            'first_options' => array('label' => 'Escolha uma Senha'),
            'second_options' => array('label' => 'Digite a Senha Novamente'),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Calm\Bundle\UserBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'register';
    }

}
