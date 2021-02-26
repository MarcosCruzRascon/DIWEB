<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211211025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, UNIQUE INDEX UNIQ_2CEDC877DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorias (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedidos (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, tipoenvio_id INT NOT NULL, idpedido VARCHAR(255) NOT NULL, anotaciones VARCHAR(255) NOT NULL, INDEX IDX_6716CCAADB38439E (usuario_id), INDEX IDX_6716CCAAF20D8644 (tipoenvio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productos (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, cantidadalmacen INT NOT NULL, precio DOUBLE PRECISION NOT NULL, INDEX IDX_767490E63397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productos_pedidos (id INT AUTO_INCREMENT NOT NULL, pedido_id INT NOT NULL, producto_id INT NOT NULL, INDEX IDX_5F082DB54854653A (pedido_id), INDEX IDX_5F082DB57645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicios (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, ventajas LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicios_contratados (id INT AUTO_INCREMENT NOT NULL, servicio_id INT NOT NULL, usuario_id INT NOT NULL, INDEX IDX_7E78517971CAA3E7 (servicio_id), INDEX IDX_7E785179DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipoenvios (id INT AUTO_INCREMENT NOT NULL, empresa_transporte VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, correo VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, dni_nif VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido1 VARCHAR(255) NOT NULL, apellido2 VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, imagen VARCHAR(255) DEFAULT NULL, nombre_empresa VARCHAR(255) DEFAULT NULL, direcciones LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', metodospago LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_EF687F277040BC9 (correo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitas (id INT AUTO_INCREMENT NOT NULL, agenda_id INT NOT NULL, fecha_hora DATETIME NOT NULL, motivo LONGTEXT NOT NULL, problemasencontrados LONGTEXT DEFAULT NULL, soluciones LONGTEXT DEFAULT NULL, realizada TINYINT(1) NOT NULL, INDEX IDX_2361FC87EA67784A (agenda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAADB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAAF20D8644 FOREIGN KEY (tipoenvio_id) REFERENCES tipoenvios (id)');
        $this->addSql('ALTER TABLE productos ADD CONSTRAINT FK_767490E63397707A FOREIGN KEY (categoria_id) REFERENCES categorias (id)');
        $this->addSql('ALTER TABLE productos_pedidos ADD CONSTRAINT FK_5F082DB54854653A FOREIGN KEY (pedido_id) REFERENCES pedidos (id)');
        $this->addSql('ALTER TABLE productos_pedidos ADD CONSTRAINT FK_5F082DB57645698E FOREIGN KEY (producto_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE servicios_contratados ADD CONSTRAINT FK_7E78517971CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicios (id)');
        $this->addSql('ALTER TABLE servicios_contratados ADD CONSTRAINT FK_7E785179DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE visitas ADD CONSTRAINT FK_2361FC87EA67784A FOREIGN KEY (agenda_id) REFERENCES agenda (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visitas DROP FOREIGN KEY FK_2361FC87EA67784A');
        $this->addSql('ALTER TABLE productos DROP FOREIGN KEY FK_767490E63397707A');
        $this->addSql('ALTER TABLE productos_pedidos DROP FOREIGN KEY FK_5F082DB54854653A');
        $this->addSql('ALTER TABLE productos_pedidos DROP FOREIGN KEY FK_5F082DB57645698E');
        $this->addSql('ALTER TABLE servicios_contratados DROP FOREIGN KEY FK_7E78517971CAA3E7');
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAAF20D8644');
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877DB38439E');
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAADB38439E');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE servicios_contratados DROP FOREIGN KEY FK_7E785179DB38439E');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE categorias');
        $this->addSql('DROP TABLE pedidos');
        $this->addSql('DROP TABLE productos');
        $this->addSql('DROP TABLE productos_pedidos');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE servicios');
        $this->addSql('DROP TABLE servicios_contratados');
        $this->addSql('DROP TABLE tipoenvios');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE visitas');
    }
}
