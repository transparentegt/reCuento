<?php
namespace Recuento\Entity;

use \Transparente\Model\Entity\AbstractDoctrineEntity;

/**
 * Las actas son los documentos de sumatorias de votos ingresados en el sistema del Tribunal Supremo Electoral, TSE
 *
 * @ORM\Entity
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
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * Alto del acta escaneada
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $height;

    /**
     * Ancho del acta escaneada
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $width;

    /**
     * Tipo de elección
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $type;

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

}