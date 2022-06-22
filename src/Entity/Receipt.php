<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $petname;

    #[ORM\Column(type: 'string', length: 255)]
    private $buyername;

    #[ORM\Column(type: 'float')]
    private $Price;

    #[ORM\Column(type: 'date')]
    private $datecreate;

    #[ORM\OneToOne(mappedBy: 'receipt', targetEntity: Pet::class, cascade: ['persist', 'remove'])]
    private $pet;

    #[ORM\ManyToOne(targetEntity: Buyer::class, inversedBy: 'receipts')]
    private $buyer;

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

    public function getBuyername(): ?string
    {
        return $this->buyername;
    }

    public function setBuyername(string $buyername): self
    {
        $this->buyername = $buyername;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->datecreate;
    }

    public function setDatecreate(\DateTimeInterface $datecreate): self
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): self
    {
        // unset the owning side of the relation if necessary
        if ($pet === null && $this->pet !== null) {
            $this->pet->setReceipt(null);
        }

        // set the owning side of the relation if necessary
        if ($pet !== null && $pet->getReceipt() !== $this) {
            $pet->setReceipt($this);
        }

        $this->pet = $pet;

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
}
