<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsuariosRepository::class)
 * @UniqueEntity(fields={"correo"}, message="Ya existe este correo en la base de datos")
 * @UniqueEntity(fields={"DNI_NIF"}, message="Ya existe este DNI/NIF en la base de datos")
 */
class Usuarios implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(allowNull = false, message="El correo no puede estar vacio")
     */
    private $correo;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank(allowNull = false, message="Debe seleccionar un rol")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(allowNull = false, message="La contraseña no puede estar vacia")
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*\d).{6,}$/i", message="La contraseña debe tener un mínimo de 6 caracteres y que incluya al menos una letra y un número.")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El campo DNI/NIF no puede estar vacio")
     */
    private $DNI_NIF;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El nombre no puede estar vacio")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El appelido no puede estar vacio")
     */
    private $apellido1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El apellido no puede estar vacio")
     */
    private $apellido2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(allowNull = false, message="El telefono no puede estar vacio")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $imagen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombreEmpresa;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $direcciones = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $metodospago = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToOne(targetEntity=Agenda::class, mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $agenda;

    /**
     * @ORM\OneToMany(targetEntity=Pedidos::class, mappedBy="usuario", orphanRemoval=true)
     */
    private $pedidos;

    /**
     * @ORM\OneToMany(targetEntity=ServiciosContratados::class, mappedBy="usuario", orphanRemoval=true)
     */
    private $serviciosContratados;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $carrito = [];



    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
        $this->serviciosContratados = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->correo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDNINIF(): ?string
    {
        return $this->DNI_NIF;
    }

    public function setDNINIF(string $DNI_NIF): self
    {
        $this->DNI_NIF = $DNI_NIF;

        return $this;
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

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2): self
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getNombreEmpresa(): ?string
    {
        return $this->nombreEmpresa;
    }

    public function setNombreEmpresa(?string $nombreEmpresa): self
    {
        $this->nombreEmpresa = $nombreEmpresa;

        return $this;
    }

    public function getDirecciones(): ?array
    {
        return $this->direcciones;
    }

    public function setDirecciones(?array $direcciones): self
    {
        $this->direcciones = $direcciones;

        return $this;
    }

    public function getMetodospago(): ?array
    {
        return $this->metodospago;
    }

    public function setMetodospago(?array $metodospago): self
    {
        $this->metodospago = $metodospago;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getAgenda(): ?Agenda
    {
        return $this->agenda;
    }

    public function setAgenda(Agenda $agenda): self
    {
        // set the owning side of the relation if necessary
        if ($agenda->getUsuario() !== $this) {
            $agenda->setUsuario($this);
        }

        $this->agenda = $agenda;

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
            $pedido->setUsuario($this);
        }

        return $this;
    }

    public function removePedido(Pedidos $pedido): self
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getUsuario() === $this) {
                $pedido->setUsuario(null);
            }
        }

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
            $serviciosContratado->setUsuario($this);
        }

        return $this;
    }

    public function removeServiciosContratado(ServiciosContratados $serviciosContratado): self
    {
        if ($this->serviciosContratados->removeElement($serviciosContratado)) {
            // set the owning side to null (unless already changed)
            if ($serviciosContratado->getUsuario() === $this) {
                $serviciosContratado->setUsuario(null);
            }
        }

        return $this;
    }

    public function getCarrito(): ?array
    {
        return $this->carrito;
    }

    public function setCarrito(?array $carrito): self
    {
        $this->carrito = $carrito;

        return $this;
    }
}
