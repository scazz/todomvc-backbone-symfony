<?php

namespace Todo\APIBundle\TodoAPIBundle\Exception;

use Symfony\Component\Form\FormInterface;

class InvalidFormException extends \RuntimeException {

    private $form;

    public function __construct($message, FormInterface $form) {
        $this->form = $form;
        parent::__construct($message);
    }

    /**
     * @return array|null
     */
    public function getForm() {
        return $this->form;
    }

}