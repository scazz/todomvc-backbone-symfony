<?php

namespace Todo\APIBundle\TodoAPIBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

use Todo\APIBundle\TodoAPIBundle\Form\APITodoType;
use Todo\APIBundle\TodoAPIBundle\Model\TodoInterface;
use Todo\APIBundle\TodoAPIBundle\Exception\InvalidFormException;
use Todo\APIBundle\TodoAPIBundle\Entity\Todo;

class TodoHandler implements TodoHandlerInterface {

    /**
     * @var ObjectManager
     */
    private $om;
    private $entityClass;
    private $formFactory;

    /* @var */
    private $repository;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory) {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->formFactory = $formFactory;

        $this->repository = $this->om->getRepository( $this->entityClass );
    }

    public function get($id) {
        return $this->repository->find($id);
    }
    public function getAll() {
        return $this->repository->findAll();
    }

    public function post(Request $request) {
        $todo = new Todo();
        return $this->processForm($todo, $request, 'POST');
    }


    private function processForm(TodoInterface $todo, Request $request, $method = 'PUT') {
        //$form = $this->createForm( new APITodoType(), $todo);

        $form = $this->formFactory->create(new APITodoType(), $todo, array('method'=>$method));
        $form->submit($request->request->all());
        //$form->handleRequest($request);


        if ( $form->isValid()) {
            $this->om->persist($todo);
            $this->om->flush();

            return $todo;
        } else {
            throw new InvalidFormException('Invalid submitted data', $form);
        }
    }

    private function createTodo() {
        return new $this->entityClass();
    }
}
