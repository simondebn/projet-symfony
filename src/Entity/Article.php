<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="author", type="string")
     * @Assert\NotBlank()
     */
    private $author;

    /**
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @ORM\Column(name="abstract", type="text", nullable=true)
     * @Assert\Length(
     *     max = 120,
     *     maxMessage = "The title must be at most {{ limit }} characters long")
     */
    private $abstract;



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\Column(name="title", type="string")
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "The title must be at least {{ limit }} characters long",
     *      max = 10,)
     *
     */
    private $title;

    /**
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->setDate();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return Collection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param
     */
    public function setDate(): void
    {
        $this->date = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param $abstract
     */
    public function setAbstract($abstract): void
    {
        $this->abstract = $abstract;
    }



    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category)
    {
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau
        $this->categories[] = $category;

        return $this;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->categories->removeElement($category);
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
