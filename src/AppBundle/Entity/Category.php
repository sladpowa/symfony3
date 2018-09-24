<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    public $type;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Articles", mappedBy="category")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Games", mappedBy="category")
     */
    public $games;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }


    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getType($this->articles). "";
        return $this->getType ($this->games). "";
    }
}


