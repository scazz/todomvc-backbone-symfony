<?php

namespace Todo\APIBundle\TodoAPIBundle\Tests\Fixtures\Entity;

use Todo\APIBundle\TodoAPIBundle\Entity\Todo;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadTodoData implements FixtureInterface {

    static public $todos = array();

    public function load(ObjectManager $objectManager) {
        $todo = new Todo();
        $todo->setCompleted(false);
        $todo->setTitle("title");

        $objectManager->persist($todo);
        $objectManager->flush();
        self::$todos[] = $todo;


        $todo2 = new Todo();
        $todo2->setCompleted(false);
        $todo2->setTitle("new todo");

        $objectManager->persist($todo2);
        $objectManager->flush();

        self::$todos[] = $todo2;

    }

}