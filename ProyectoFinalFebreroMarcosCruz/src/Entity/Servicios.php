<?php

namespace App\Entity;

use App\Repository\ServiciosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ServiciosRepository::class)
 */
class Servicios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El nombre no puede estar vacio")
     */
    private $nombre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(allowNull = false, message="Las ventajas no pueden estar vacias")
     */
    private $ventajas;

    /**
     * @ORM\OneToMany(targetEntity=ServiciosContratados::class, mappedBy="servicio", orphanRemoval=true)
     */
    private $serviciosContratados;

    public function __construct()
    {
        $this->serviciosContratados = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getVentajas(): ?string
    {
        return $this->ventajas;
    }

    public function setVentajas(string $ventajas): self
    {
        $this->ventajas = $ventajas;

        return $this;
    }

    /**
     * @return Collection|ServiciosContratados[]
     */
    public function getServiciosContratados(): Collection
    {
        return $this->serviciosContratados;
    }

    public function addServiciosContratado(ServiciosContratados $serviciosContratado): self
    {
        if (!$this->serviciosContratados->contains($serviciosContratado)) {
            $this->serviciosContratados[] = $serviciosContratado;
            $serviciosContratado->setServicio($this);
        }

        return $this;
    }

    public function removeServiciosContratado(ServiciosContratados $serviciosContratado): self
    {
        if ($this->serviciosContratados->removeElement($serviciosContratado)) {
            // set the owning side to null (unless already changed)
            if ($serviciosContratado->getServicio() === $this) {
                $serviciosContratado->setServicio(null);
            }
        }

        return $this;
    }
}
