<?php

namespace App\Entity;

use App\Repository\TipoenviosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TipoenviosRepository::class)
 */
class Tipoenvios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El nombre de la empresa no puede estar vacio")
     */
    private $empresaTransporte;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(allowNull = false, message="El precio no puede estar vacio")
     */
    private $precio;

    /**
     * @ORM\OneToMany(targetEntity=Pedidos::class, mappedBy="tipoenvio", orphanRemoval=true)
     */
    private $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmpresaTransporte(): ?string
    {
        return $this->empresaTransporte;
    }

    public function setEmpresaTransporte(string $empresaTransporte): self
    {
        $this->empresaTransporte = $empresaTransporte;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return Collection|Pedidos[]
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedidos $pedido): self
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos[] = $pedido;
            $pedido->setTipoenvio($this);
        }

        return $this;
    }

    public function removePedido(Pedidos $pedido): self
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getTipoenvio() === $this) {
                $pedido->setTipoenvio(null);
            }
        }

        return $this;
    }
}
