<?php

namespace Todo\APIBundle\TodoAPIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Todo\APIBundle\TodoAPIBundle\Entity\Todo;
use Todo\APIBundle\TodoAPIBundle\Exception\InvalidFormException;
use Todo\APIBundle\TodoAPIBundle\Form\TodoType;
use Todo\APIBundle\TodoAPIBundle\Form\APITodoType;


class TodoController extends FOSRestController
{

    /**
     * @Route("/")
     */
    public function indexAction() {
        $x = 1;
    }

    /**
     * @param $id
     * @return array
     * @Annotations\View(templateVar="todo")
     */
    public function getTodoAction( $id )
    {
        return $this->getOr404($id);
    }

    /**
     * @return mixed
     */
    public function getTodosAction()
    {
        return $this
            ->container
            ->get('todo_api.todo.handler')
            ->getAll();
    }


    /**
     * @Annotations\View(
     *  template = "TodoAPIBundle:Todo:newTodo.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     * @param Request $request the request object
     * @return FormTypeInterface|View
     */
    public function postTodoAction(Request $request)
    {
        try {
             $newTodo = $this
                ->container
                ->get('todo_api.todo.handler')
                ->post( $request );

        } catch(InvalidFormException $x) {
            return $x->getForm();
        }

        $response = $this->forward('TodoAPIBundle:Todo:getTodo', array('id' => $newTodo->getId()), array('_format'=>'json' ));
        $response->setStatusCode("201");
        return $response;

    }

    /**
     * @Annotations\View(
     *  template = "AcmeBlogBundle:Page:editPage.html.twig",
     *  templateVar = "form"
     * )
     * @throws NotFoundHttpException
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function putTodoAction(Request $request, $id) {
        $todo = $this->getOr404($id);

        try {
            $todo = $this->container->get('todo_api.todo.handler')->put($todo, $request);
        } catch(InvalidFormException $x) {
            return $x->getForm();
        }
        $response = $this->forward('TodoAPIBundle:Todo:getTodo', array('id' => $todo->getId()), array('_format'=>'json' ));
        $response->setStatusCode("200");
        return $response;
    }

    public function deleteTodoAction(Request $request, $id) {
        $todo = $this->getOr404($id);
        $this->container->get('todo_api.todo.handler')->delete($todo);

        $response = new Response();
        $response->setStatusCode(204);
        return $response;

    }




    protected function getOr404( $id=NULL )
    {
        $todo = $this
            ->container
            ->get('todo_api.todo.handler')
            ->get( $id );

        if (!$todo) {
            throw new NotFoundHttpException("The todo with ID %id was not found");
        }
        return $todo;
    }
}
