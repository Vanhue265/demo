<?php

namespace App\Entity;

use App\Repository\StaffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffRepository::class)]
class Staff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $staffname;

    #[ORM\Column(type: 'string', length: 255)]
    private $staffphone;

    #[ORM\Column(type: 'string', length: 255)]
    private $staffaddress;

    #[ORM\ManyToMany(targetEntity: Pet::class, mappedBy: 'staffs')]
    private $pets;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffname(): ?string
    {
        return $this->staffname;
    }

    public function setStaffname(string $staffname): self
    {
        $this->staffname = $staffname;

        return $this;
    }

    public function getStaffphone(): ?string
    {
        return $this->staffphone;
    }

    public function setStaffphone(string $staffphone): self
    {
        $this->staffphone = $staffphone;

        return $this;
    }

    public function getStaffaddress(): ?string
    {
        return $this->staffaddress;
    }

    public function setStaffaddress(string $staffaddress): self
    {
        $this->staffaddress = $staffaddress;

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
            $pet->addStaff($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            $pet->removeStaff($this);
        }

        return $this;
    }
}
