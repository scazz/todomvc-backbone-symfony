<?php

namespace Todo\APIBundle\TodoAPIBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Todo\APIBundle\TodoAPIBundle\Tests\Fixtures\Entity\LoadTodoData;

class TodoControllerTest extends WebTestCase
{
    private $client;

    private function setUpTest() {
        $this->client = static::createClient();
    }

    private function loadTodosFixtures() {
        $fixtures = array( 'Todo\APIBundle\TodoAPIBundle\Tests\Fixtures\Entity\LoadTodoData');
        $this->loadFixtures( $fixtures );
        return LoadTodoData::$todos;
    }

    public function testJsonGetTodoAction()
    {
        $this->setUpTest();
        $todos = $this->loadTodosFixtures();
        $this->todo = array_pop($todos);

        $route =  $this->getUrl('api_1_get_todo', array('id' => $this->todo->getId(), '_format' => 'json'));

        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse( $response );

        $content = $response->getContent();
        $decodedContent = json_decode($content, true);

        $this->assertTrue( isset($decodedContent['title']) );
        $this->assertTrue( isset($decodedContent['completed']) );
        $this->assertTrue( isset($decodedContent['id']) );
    }

    public function testJsonGetTodosAction()
    {
        $this->setUpTest();
        $this->loadTodosFixtures();

        $route =  $this->getUrl('api_1_get_todos', array( '_format' => 'json'));
        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));

        $response = $this->client->getResponse();
        $this->assertJsonResponse( $response );

        $content = $response->getContent();
        $todos = json_decode($content, true);

        $this->assertGreaterThan(1, count($todos));
        foreach ($todos as $todo) {
            $this->assertTrue( isset($todo['title']) );
            $this->assertTrue( isset($todo['completed']) );
            $this->assertTrue( isset($todo['id']) );
        }
    }

    public function testGetTodoActionForInvalidIdThrows404()
    {
        $client = static::createClient();
        $route =  $this->getUrl('api_1_get_todo', array('id' =>0, '_format' => 'json'));
        $client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $client->getResponse();

        $this->assertEquals( 404, $response->getStatusCode());
    }


    public function testJsonPostTodoAction()
    {
        $serializedTodo = '{"title":"title2","completed":true}';
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/todos.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $serializedTodo
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 201, false );

        $returnedTodo = json_decode($response->getContent());
        $originalTodo = json_decode($serializedTodo);
        $this->assertEquals($originalTodo->title, $returnedTodo->title);
        $this->assertEquals($originalTodo->completed, $returnedTodo->completed);
    }


    /*
     * Private functions
     */

    protected function assertJsonResponse($response, $statusCode = 200, $checkValidJson =  true, $contentType = 'application/json')
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );

        if ($checkValidJson) {
            $decode = json_decode($response->getContent());
            $this->assertTrue(($decode != null && $decode != false),
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }
}