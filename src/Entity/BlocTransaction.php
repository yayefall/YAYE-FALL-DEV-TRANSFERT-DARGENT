<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BlocTransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *
 *         normalizationContext={"groups"={"bloctrans:read"}},
 *         denormalizationContext={"groups"={"bloctrans:write"}},
 * )
 * @ORM\Entity(repositoryClass=BlocTransactionRepository::class)
 */
class BlocTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $partEntreprise;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $partAgentRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $partAgentDepot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $clients;

    /**
     * @ORM\Column(type="date")
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $dateRetrait;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="blockTransactionDepot")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $userDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="blockTransactionRetrait")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"bloctrans:read","bloctrans:write"})
     */
    private $userRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="blocTransactionDepot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="blocTransactionRetrait")
     */
    private $compteRetrait;


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

    public function getClients(): ?Client
    {
        return $this->clients;
    }

    public function setClients(Client $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }


    public function getUserDepot(): ?User
    {
        return $this->userDepot;
    }

    public function setUserDepot(?User $userDepot): self
    {
        $this->userDepot = $userDepot;

        return $this;
    }

    public function getUserRetrait(): ?User
    {
        return $this->userRetrait;
    }

    public function setUserRetrait(?User $userRetrait): self
    {
        $this->userRetrait = $userRetrait;

        return $this;
    }

    public function getCompteDepot(): ?Compte
    {
        return $this->compteDepot;
    }

    public function setCompteDepot(?Compte $compteDepot): self
    {
        $this->compteDepot = $compteDepot;

        return $this;
    }

    public function getCompteRetrait(): ?Compte
    {
        return $this->compteRetrait;
    }

    public function setCompteRetrait(?Compte $compteRetrait): self
    {
        $this->compteRetrait = $compteRetrait;

        return $this;
    }


}
