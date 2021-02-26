<?php

namespace App\Entity;

use App\Repository\VisitasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitasRepository::class)
 */
class Visitas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaHora;

    /**
     * @ORM\Column(type="text")
     */
    private $motivo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $problemasencontrados;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $soluciones;

    /**
     * @ORM\Column(type="boolean")
     */
    private $realizada;

    /**
     * @ORM\ManyToOne(targetEntity=Agenda::class, inversedBy="visitas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agenda;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHora(): ?\DateTimeInterface
    {
        return $this->fechaHora;
    }

    public function setFechaHora(\DateTimeInterface $fechaHora): self
    {
        $this->fechaHora = $fechaHora;

        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): self
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getProblemasencontrados(): ?string
    {
        return $this->problemasencontrados;
    }

    public function setProblemasencontrados(?string $problemasencontrados): self
    {
        $this->problemasencontrados = $problemasencontrados;

        return $this;
    }

    public function getSoluciones(): ?string
    {
        return $this->soluciones;
    }

    public function setSoluciones(?string $soluciones): self
    {
        $this->soluciones = $soluciones;

        return $this;
    }

    public function getRealizada(): ?bool
    {
        return $this->realizada;
    }

    public function setRealizada(bool $realizada): self
    {
        $this->realizada = $realizada;

        return $this;
    }

    public function getAgenda(): ?Agenda
    {
        return $this->agenda;
    }

    public function setAgenda(?Agenda $agenda): self
    {
        $this->agenda = $agenda;

        return $this;
    }

}
