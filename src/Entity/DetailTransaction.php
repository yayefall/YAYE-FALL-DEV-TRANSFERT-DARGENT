<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DetailTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DetailTransactionRepository::class)
 */
class DetailTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $partEtat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $partSysteme;

    /**
     * @ORM\Column(type="integer")
     */
    private $partOperateurDepot;

    /**
     * @ORM\Column(type="integer")
     */
    private $partOperateurRetrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraiTransaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }

    public function getPartSysteme(): ?int
    {
        return $this->partSysteme;
    }

    public function setPartSysteme(int $partSysteme): self
    {
        $this->partSysteme = $partSysteme;

        return $this;
    }

    public function getPartOperateurDepot(): ?int
    {
        return $this->partOperateurDepot;
    }

    public function setPartOperateurDepot(int $partOperateurDepot): self
    {
        $this->partOperateurDepot = $partOperateurDepot;

        return $this;
    }

    public function getPartOperateurRetrait(): ?int
    {
        return $this->partOperateurRetrait;
    }

    public function setPartOperateurRetrait(int $partOperateurRetrait): self
    {
        $this->partOperateurRetrait = $partOperateurRetrait;

        return $this;
    }

    public function getFraiTransaction(): ?int
    {
        return $this->fraiTransaction;
    }

    public function setFraiTransaction(int $fraiTransaction): self
    {
        $this->fraiTransaction = $fraiTransaction;

        return $this;
    }
}
