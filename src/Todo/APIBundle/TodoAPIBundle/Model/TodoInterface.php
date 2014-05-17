<?php

namespace Todo\APIBundle\TodoAPIBundle\Model;

Interface TodoInterface {

    public function setTitle( $title );
    public function getTitle( );

    public function setCompleted( $completed);
    public function getCompleted();

}