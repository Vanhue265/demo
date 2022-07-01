<?php

namespace App\Entity;

use App\Repository\BuyerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuyerRepository::class)]
class Buyer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $buyername;

    #[ORM\Column(type: 'string', length: 255)]
    private $buyerphone;

    #[ORM\Column(type: 'string', length: 255)]
    private $buyeraddress;

    #[ORM\OneToMany(mappedBy: 'buyer', targetEntity: Pet::class)]
    private $pets;

    #[ORM\OneToMany(mappedBy: 'buyer', targetEntity: Receipt::class)]
    private $receipts;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
        $this->receipts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyername(): ?string
    {
        return $this->buyername;
    }

    public function setBuyername(string $buyername): self
    {
        $this->buyername = $buyername;

        return $this;
    }

    public function getBuyerphone(): ?string
    {
        return $this->buyerphone;
    }

    public function setBuyerphone(string $buyerphone): self
    {
        $this->buyerphone = $buyerphone;

        return $this;
    }

    public function getBuyeraddress(): ?string
    {
        return $this->buyeraddress;
    }

    public function setBuyeraddress(string $buyeraddress): self
    {
        $this->buyeraddress = $buyeraddress;

        return $this;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets[] = $pet;
            $pet->setBuyer($this);
        }

        return $this;
    }
    
    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getBuyer() === $this) {
                $pet->setBuyer();
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Receipt>
     */
    public function getReceipts(): Collection
    {
        return $this->receipts;
    }

    public function addReceipt(Receipt $receipt): self
    {
        if (!$this->receipts->contains($receipt)) {
            $this->receipts[] = $receipt;
            $receipt->setBuyer($this);
        }

        return $this;
    }

    public function removeReceipt(Receipt $receipt): self
    {
        if ($this->receipts->removeElement($receipt)) {
            // set the owning side to null (unless already changed)
            if ($receipt->getBuyer() === $this) {
                $receipt->setBuyer();
            }
        }

        return $this;
    }
}
