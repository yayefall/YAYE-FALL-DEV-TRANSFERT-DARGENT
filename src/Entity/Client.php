<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *       routePrefix="/useragence",
 *    attributes={
 *           "pagination_enabled"=true,
 *           "pagination_items_per_page"=100,
 *           "security"="is_granted('ROLE_UserAgence')",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *
 *      collectionOperations={"post","get"},
 *      itemOperations={"put","get","delete"},
 *
 *         normalizationContext={"groups"={"client:read"}},
 *         denormalizationContext={"groups"={"client:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="le nomClient est obligatoire" )
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $nomClient;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="le nomBeneficiaire est obligatoire" )
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $nomBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank( message="le CNIclient est obligatoire" )
     * @Assert\Length(
     *     min=13,
     *     max=13,
     *     maxMessage="votre CNI ne depasse pas  13 chiffres")
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $CNIClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank( message="le CNIbeneficiaire est obligatoire")
     * @Assert\Length(
     *     min=13,
     *     max=13,
     *     maxMessage="votre CNI ne depasse pas  13 chiffres")
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $CNIBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="le telephoneClient est obligatoire" )
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $telephoneClient;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="le telephoneBeneficiaire est obligatoire" )
     * @Groups({"client:read","client:write","trans:write","trans:read"})
     */
    private $telephoneBeneficiaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

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

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }
}
