<?php

namespace App\Entity;

use App\Repository\ArticleLikesRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\traits\Timer;

/**
 * @ORM\Entity(repositoryClass=ArticleLikesRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ArticleLikes
{
    /**
     * TimesTampableTrait
     */
    use Timer;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="likes")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
