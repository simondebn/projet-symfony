<?php
/**
 * Created by PhpStorm.
 * User: cdi
 * Date: 08/03/2018
 * Time: 14:43
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="body", type="text")
     * @Assert\Length(
     *      max = 300,
     *      maxMessage = "The comment must be at most {{ limit }} characters long")
     */
    private $body;

    /**
     * @ORM\Column(name="author", type="text")
     * @Assert\Length(
     *      max = 20,
     *      maxMessage = "The name must be at most {{ limit }} characters long")
     */
    private $author;

    /**
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $article;

    public function __construct()
    {
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
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article): void
    {
        $this->article = $article;
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


}