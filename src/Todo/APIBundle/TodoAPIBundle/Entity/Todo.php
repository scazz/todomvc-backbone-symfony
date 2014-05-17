<?php

namespace Todo\APIBundle\TodoAPIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Todo\APIBundle\TodoAPIBundle\Model\TodoInterface;

/**
 * @ORM\Table(name="todo")
 * @ORM\Entity
 */
class Todo implements TodoInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private  $title;

    /**
     * @ORM\Column(name="completed", type="boolean", nullable=false)
     */
    private  $completed;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getCompleted() {
        return $this->completed;
    }
    public function setCompleted( $completed ) {
        $this->completed = $completed;
        return $this;
    }
}