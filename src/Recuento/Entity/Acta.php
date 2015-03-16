<?php
namespace Recuento\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Transparente\Model\Entity\AbstractDoctrineEntity;

/**
 * Las actas son los documentos de sumatorias de votos ingresados en el sistema del Tribunal Supremo Electoral, TSE
 *
 * @ORM\Entity(repositoryClass="Recuento\Repository\ActaRepository")
 * @ORM\Table(name="recuento_acta")
 */
class Acta extends AbstractDoctrineEntity
{
    const TYPE_PRESIDENT         = 1;
    const TYPE_DIPUTADO_NACIONAL = 2;
    const TYPE_DIPUTADO_DISTRITO = 3;
    const TYPE_MUNICIPAL         = 4;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $id;

    /**
     * Alto del acta escaneada
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $height = 0;


    /**
     * Ancho del acta escaneada
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $mesa;


    /**
     * Tipo de elección
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $type;

    /**
     * Ancho del acta escaneada
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $width = 0;

    /**
     * Listado de posibles tipos de actas
     *
     * @var string[]
     */
    public static $types = [
        self::TYPE_PRESIDENT         => 'presidente y vicepresidente',
        self::TYPE_DIPUTADO_DISTRITO => 'diputados distritales',
        self::TYPE_DIPUTADO_NACIONAL => 'diputados lista nacional',
        self::TYPE_MUNICIPAL         => 'corporación municipal',
    ];

    /**
     * @return the $id
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * Returns image path
     *
     * @return string
     */
    public function getImage()
    {

        $dir  = __DIR__ . '/../../../data/actas/';
        $dir  = realpath($dir);
        $path = sprintf($dir . '/%d/%05d%1$d.jpg', $this->getType(), $this->getId());
        return $path;
    }

    /**
     * @return the $height
     */
    public function getHeight ()
    {
        return $this->height;
    }

    /**
     * @return the $mesa
     */
    public function getMesa ()
    {
        return $this->mesa;
    }
    /**
     * @return the $width
     */
    public function getWidth ()
    {
        return $this->width;
    }

    /**
     * @return the $type
     */
    public function getType ()
    {
        return $this->type;
    }

    /**
     * @param number $height
     */
    public function setHeight ($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param number $id
     */
    public function setMesa($mesa)
    {
        $mesa = (int) $mesa;
        if ($mesa < 1) throw new \Exception('Mesa inválida');
        $this->mesa = $mesa;
        return $this;
    }

    /**
     * @param number $width
     */
    public function setWidth ($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param number $type
     */
    public function setType ($type)
    {
        $this->type = $type;
        return $this;
    }


}