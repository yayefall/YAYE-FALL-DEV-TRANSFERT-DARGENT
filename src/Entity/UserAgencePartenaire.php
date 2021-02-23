<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserAgencePartenaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserAgencePartenaireRepository::class)
 */
class UserAgencePartenaire extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=CompteTransaction::class, cascade={"persist", "remove"})
     */
    private $compteTransactions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteTransactions(): ?CompteTransaction
    {
        return $this->compteTransactions;
    }

    public function setCompteTransactions(?CompteTransaction $compteTransactions): self
    {
        $this->compteTransactions = $compteTransactions;

        return $this;
    }
}
