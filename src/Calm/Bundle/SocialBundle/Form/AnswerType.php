<?php

namespace Calm\Bundle\SocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnswerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('description', 'textarea', array('label'=>'Resposta'));

   
    }

    
    public function getName() {
        return 'answer';
    }
    
}
