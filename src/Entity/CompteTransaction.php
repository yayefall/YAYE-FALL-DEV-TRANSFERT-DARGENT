<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteTransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *       routePrefix="/adminSysteme",
 *     attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=4,
 *           "security"="is_granted('ROLE_adminSysteme')",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *      collectionOperations={},
 *      itemOperations={},
 *         normalizationContext={"groups"={"compte:read"}},
 *         denormalizationContext={"groups"={"compte:write"}}
 * )
 * @ORM\Entity(repositoryClass=CompteTransactionRepository::class)
 */
class CompteTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte:read","compte:write"})
     */
    private $id;

    /**
     * @Assert\NotBlank( message="le solde est obligatoire" )
     * @Groups({"compte:read","compte:write"})
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @Assert\NotBlank( message="la date est obligatoire" )
     * @Groups({"compte:read","compte:write"})
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

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
}
