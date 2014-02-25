<?php

namespace Calm\Bundle\SocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('description', 'textarea', array('label'=>' '));

   
    }

    
    public function getName() {
        return 'question';
    }
    
}
