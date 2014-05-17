<?php

namespace Todo\APIBundle\TodoAPIBundle\Handler;

use Todo\APIBundle\TodoAPIBundle\Model\TodoInterface;
use Symfony\Component\HttpFoundation\Request;

Interface TodoHandlerInterface {
    public function get($id);
    public function put(TodoInterface $todo, Request $request);
}