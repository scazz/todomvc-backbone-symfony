<?php

namespace Todo\APIBundle\TodoAPIBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class APITodoType extends TodoType {

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults( array(
               'csrf_protection' => false,
                'data_class' => 'Todo\APIBundle\TodoAPIBundle\Entity\Todo'
            ));
    }

}