<?php

namespace App\Entity;

use App\Repository\ProductosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductosRepository::class)
 */
class Productos implements JsonSerializable
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
     * @Assert\NotBlank(allowNull = false, message="La descripcion no puede estar vacia")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(allowNull = false, message="La cantidad no puede estar vacia")
     */
    private $cantidadalmacen;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(allowNull = false, message="El precio no puede estar vacio")
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity=Categorias::class, inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(allowNull = false, message="Seleccione una categoria")
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity=ProductosPedidos::class, mappedBy="producto", orphanRemoval=true)
     */
    private $productosPedidos;

    /**
     * @ORM\Column(type="array")
     */
    private $imagenes = [];

    public function __construct()
    {
        $this->productosPedidos = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCantidadalmacen(): ?int
    {
        return $this->cantidadalmacen;
    }

    public function setCantidadalmacen(int $cantidadalmacen): self
    {
        $this->cantidadalmacen = $cantidadalmacen;

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

    public function getCategoria(): ?Categorias
    {
        return $this->categoria;
    }

    public function setCategoria(?Categorias $categoria): self
    {
        $this->categoria = $categoria;

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
            $productosPedido->setProducto($this);
        }

        return $this;
    }

    public function removeProductosPedido(ProductosPedidos $productosPedido): self
    {
        if ($this->productosPedidos->removeElement($productosPedido)) {
            // set the owning side to null (unless already changed)
            if ($productosPedido->getProducto() === $this) {
                $productosPedido->setProducto(null);
            }
        }

        return $this;
    }

    public function getImagenes(): ?array
    {
        return $this->imagenes;
    }

    public function setImagenes(array $imagenes): self
    {
        $this->imagenes = $imagenes;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'cantidadalmacen' => $this->getCantidadalmacen(),
            'precio' => $this->getPrecio(),
            'categoria' => $this->getCategoria()->getNombre(),
            'imagenes' => $this->getImagenes()
        ];
    }

   
}
