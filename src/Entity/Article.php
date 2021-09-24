<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\traits\Timer;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Article
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
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=ArticleLikes::class, mappedBy="article")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=ArticleReview::class, mappedBy="article", orphanRemoval=true)
     */
    private $articleReviews;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="articles")
     */
    private $tags;

    public function __construct()
    {
        $this->postLikes = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->articleReviews = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|PostLike[]
     */
    public function getPostLikes(): Collection
    {
        return $this->postLikes;
    }

    /**
     * @return Collection|ArticleLikes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ArticleLikes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setArticle($this);
        }

        return $this;
    }

    public function removeLike(ArticleLikes $like): self
    {
        if ($this->likes->removeElement($like)) {
            
            if ($like->getArticle() === $this) {
                $like->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * Permet de savoir si cet article est liker pas l utilisateur conecter
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user): bool
    {
        foreach($this->likes as $like) {
            if($like->getUser() === $user) return true;
        }
        return false;
    }

    /**
     * @return Collection|ArticleReview[]
     */
    public function getArticleReviews(): Collection
    {
        return $this->articleReviews;
    }

    public function addArticleReview(ArticleReview $articleReview): self
    {
        if (!$this->articleReviews->contains($articleReview)) {
            $this->articleReviews[] = $articleReview;
            $articleReview->setArticle($this);
        }

        return $this;
    }

    public function removeArticleReview(ArticleReview $articleReview): self
    {
        if ($this->articleReviews->removeElement($articleReview)) {
            // set the owning side to null (unless already changed)
            if ($articleReview->getArticle() === $this) {
                $articleReview->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
