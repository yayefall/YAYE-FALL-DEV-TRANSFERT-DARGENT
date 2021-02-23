<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      routePrefix="/adminSysteme",
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=4,
 *           "security"="is_granted('ROLE_adminSysteme')",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *      collectionOperations={},
 *      itemOperations={},
 *         normalizationContext={"groups"={"trans:read"}},
 *         denormalizationContext={"groups"={"trans:write"}}
 * )
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank( message="le type est obligatoire")
     * @Groups({"trans:read","trans:read"})
     */
    private $typeTransaction;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le montant est obligatoire")
     * @Groups({"trans:read","trans:read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="le code transaction est obligatoire")
     * @Groups({"trans:read","trans:read"})
     */
    private $codeTransaction;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank( message="le statut est obligatoire")
     * @Groups({"trans:read","trans:read"})
     */
    private $statutTransaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(string $typeTransaction): self
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCodeTransaction(): ?string
    {
        return $this->codeTransaction;
    }

    public function setCodeTransaction(string $codeTransaction): self
    {
        $this->codeTransaction = $codeTransaction;

        return $this;
    }

    public function getStatutTransaction(): ?bool
    {
        return $this->statutTransaction;
    }

    public function setStatutTransaction(bool $statutTransaction): self
    {
        $this->statutTransaction = $statutTransaction;

        return $this;
    }
}
