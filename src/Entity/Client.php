<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $nomClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CNIClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CNIBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneBeneficiaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getNomBeneficiaire(): ?string
    {
        return $this->nomBeneficiaire;
    }

    public function setNomBeneficiaire(string $nomBeneficiaire): self
    {
        $this->nomBeneficiaire = $nomBeneficiaire;

        return $this;
    }

    public function getCNIClient(): ?string
    {
        return $this->CNIClient;
    }

    public function setCNIClient(string $CNIClient): self
    {
        $this->CNIClient = $CNIClient;

        return $this;
    }

    public function getCNIBeneficiaire(): ?string
    {
        return $this->CNIBeneficiaire;
    }

    public function setCNIBeneficiaire(string $CNIBeneficiaire): self
    {
        $this->CNIBeneficiaire = $CNIBeneficiaire;

        return $this;
    }

    public function getTelephoneClient(): ?string
    {
        return $this->telephoneClient;
    }

    public function setTelephoneClient(string $telephoneClient): self
    {
        $this->telephoneClient = $telephoneClient;

        return $this;
    }

    public function getTelephoneBeneficiaire(): ?string
    {
        return $this->telephoneBeneficiaire;
    }

    public function setTelephoneBeneficiaire(string $telephoneBeneficiaire): self
    {
        $this->telephoneBeneficiaire = $telephoneBeneficiaire;

        return $this;
    }
}
