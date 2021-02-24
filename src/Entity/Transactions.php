<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=100,
 *           "security"="(is_granted('ROLE_UserAgence')|| is_granted('ROLE_AdminAgence') )",
 *           "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *      collectionOperations={
 *                "POST-transaction-for-UserAgence"={
 *                         "method"="post",
 *                         "path"="/useragence/transactions",
 *                    },
 *               "GET-transaction-for-UserAgence"={
 *                          "method"="get",
 *                          "path"="/useragence/transactions",
 *                      },
 *
 *                "POST-transaction-for-AdminAgence"={
 *                         "method"="post",
 *                         "path"="/adminagence/transactions",
 *                    },
 *                "GET-transaction-for-AdminAgence"={
 *                          "method"="get",
 *                          "path"="/adminagence/transactions",
 *                      },
 *
 *         },
 *      itemOperations={
 *              "PUT-transaction-for-UserAgence"={
 *                         "method"="put",
 *                         "path"="/useragence/transactions/{id}",
 *                 },
 *              "GET-transaction-for-UserAgence"={
 *                          "method"="get",
 *                          "path"="/useragence/transactions/{id}",
 *                },
 *              "DELETE-transaction-for-UserAgence"={
 *                           "method"="delete",
 *                          "path"="/useragence/transactions/{id}",
 *               },
 *
 *
 *
 *               "PUT-transaction-for-AdminAgence"={
 *                         "method"="put",
 *                         "path"="/adminagence/transactions/{id}",
 *                 },
 *              "GET-transaction-for-AdminAgence"={
 *                          "method"="get",
 *                          "path"="/adminagence/transactions/{id}",
 *                },
 *              "DELETE-transaction-for-AdminAgence"={
 *                           "method"="delete",
 *                          "path"="/adminagence/transactions/{id}",
 *               },
 *        },
 *
 *         normalizationContext={"groups"={"trans:read"}},
 *         denormalizationContext={"groups"={"trans:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 */
class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"trans:read","trans:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="le code est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le montant est obligatoire" )
     * @Assert\Length(
     *     min=5000,
     *     maxMessage="votre montant doit etre au moins  5000 FCFA")
     * @Groups({"trans:read","trans:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank( message="la date est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $creatAt;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le type est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $typeTransaction;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="la part Etat est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="la part Entreprise est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $partEntreprise;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="la part AgenceRetrait est obligatoire" )
     * @Groups({"trans:read","trans:write"})
     */
    private $partAgentRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="la part AgenceDepot est obligatoire" )
     * @Groups({"trans:read","trans:write","user:write"})
     */
    private $partAgentDepot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     * @Groups({"trans:read","trans:write"})
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     * @Groups({"trans:read","trans:write"})
     */
    private $clients;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
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

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getPartEntreprise(): ?int
    {
        return $this->partEntreprise;
    }

    public function setPartEntreprise(int $partEntreprise): self
    {
        $this->partEntreprise = $partEntreprise;

        return $this;
    }

    public function getPartAgentRetrait(): ?int
    {
        return $this->partAgentRetrait;
    }

    public function setPartAgentRetrait(int $partAgentRetrait): self
    {
        $this->partAgentRetrait = $partAgentRetrait;

        return $this;
    }

    public function getPartAgentDepot(): ?int
    {
        return $this->partAgentDepot;
    }

    public function setPartAgentDepot(int $partAgentDepot): self
    {
        $this->partAgentDepot = $partAgentDepot;

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

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getClients(): ?Client
    {
        return $this->clients;
    }

    public function setClients(?Client $clients): self
    {
        $this->clients = $clients;

        return $this;
    }
}
