<?php

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidosRepository::class)
 */
class Pedidos
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
    private $idpedido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $anotaciones;

    /**
     * @ORM\ManyToOne(targetEntity=Usuarios::class, inversedBy="pedidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity=Tipoenvios::class, inversedBy="pedidos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tipoenvio;

    /**
     * @ORM\OneToMany(targetEntity=ProductosPedidos::class, mappedBy="pedido", orphanRemoval=true)
     */
    private $productosPedidos;

  
    public function __construct()
    {
        $this->productosPedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdpedido(): ?string
    {
        return $this->idpedido;
    }

    public function setIdpedido(string $idpedido): self
    {
        $this->idpedido = $idpedido;

        return $this;
    }

    public function getAnotaciones(): ?string
    {
        return $this->anotaciones;
    }

    public function setAnotaciones(string $anotaciones): self
    {
        $this->anotaciones = $anotaciones;

        return $this;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getTipoenvio(): ?Tipoenvios
    {
        return $this->tipoenvio;
    }

    public function setTipoenvio(?Tipoenvios $tipoenvio): self
    {
        $this->tipoenvio = $tipoenvio;

        return $this;
    }

    /**
     * @return Collection|ProductosPedidos[]
     */
    public function getProductosPedidos(): Collection
    {
        return $this->productosPedidos;
    }

    public function addProductosPedido(ProductosPedidos $productosPedido): self
    {
        if (!$this->productosPedidos->contains($productosPedido)) {
            $this->productosPedidos[] = $productosPedido;
            $productosPedido->setPedido($this);
        }

        return $this;
    }

    public function removeProductosPedido(ProductosPedidos $productosPedido): self
    {
        if ($this->productosPedidos->removeElement($productosPedido)) {
            // set the owning side to null (unless already changed)
            if ($productosPedido->getPedido() === $this) {
                $productosPedido->setPedido(null);
            }
        }

        return $this;
    }

}
