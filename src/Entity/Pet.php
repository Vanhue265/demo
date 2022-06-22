<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $petname;

    #[ORM\Column(type: 'string', length: 255)]
    private $petgender;

    #[ORM\Column(type: 'string', length: 255)]
    private $pettype;

    #[ORM\Column(type: 'string', length: 255)]
    private $petimage;

    #[ORM\ManyToOne(targetEntity: Buyer::class, inversedBy: 'pets')]
    private $buyer;

    #[ORM\OneToOne(inversedBy: 'pet', targetEntity: Receipt::class, cascade: ['persist', 'remove'])]
    private $receipt;

    #[ORM\ManyToMany(targetEntity: Staff::class, inversedBy: 'pets')]
    private $staffs;

    public function __construct()
    {
        $this->staffs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPetname(): ?string
    {
        return $this->petname;
    }

    public function setPetname(string $petname): self
    {
        $this->petname = $petname;

        return $this;
    }

    public function getPetgender(): ?string
    {
        return $this->petgender;
    }

    public function setPetgender(string $petgender): self
    {
        $this->petgender = $petgender;

        return $this;
    }

    public function getPettype(): ?string
    {
        return $this->pettype;
    }

    public function setPettype(string $pettype): self
    {
        $this->pettype = $pettype;

        return $this;
    }

    public function getPetimage(): ?string
    {
        return $this->petimage;
    }

    public function setPetimage(string $petimage): self
    {
        $this->petimage = $petimage;

        return $this;
    }

    public function getBuyer(): ?Buyer
    {
        return $this->buyer;
    }

    public function setBuyer(?Buyer $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }

    public function setReceipt(?Receipt $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs[] = $staff;
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        $this->staffs->removeElement($staff);

        return $this;
    }
}
