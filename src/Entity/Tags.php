<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
#[ApiResource]
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Annoucement::class, mappedBy="tags")
     */
    private $annoucements;

    public function __construct()
    {
        $this->annoucements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Annoucement[]
     */
    public function getAnnoucements(): Collection
    {
        return $this->annoucements;
    }

    public function addAnnoucement(Annoucement $annoucement): self
    {
        if (!$this->annoucements->contains($annoucement)) {
            $this->annoucements[] = $annoucement;
            $annoucement->addTag($this);
        }

        return $this;
    }

    public function removeAnnoucement(Annoucement $annoucement): self
    {
        if ($this->annoucements->removeElement($annoucement)) {
            $annoucement->removeTag($this);
        }

        return $this;
    }
}
