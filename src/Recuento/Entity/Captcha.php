<?php
namespace Recuento\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Transparente\Model\Entity\AbstractDoctrineEntity;

/**
 * Los captchas de los números de las actas
 *
 * @ORM\Entity(repositoryClass="Recuento\Repository\CaptchaRepository")
 * @ORM\Table(name="recuento_captcha")
 */
class Captcha extends AbstractDoctrineEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Acta")
     * @ORM\JoinColumn(name="id_acta", referencedColumnName="id")
     */
    protected $acta;

    /**
     * @ORM\ManyToOne(targetEntity="\Transparente\Model\Entity\PartidoPolitico")
     * @ORM\JoinColumn(name="id_partido", referencedColumnName="id")
     */
    protected $partido;

    /**
     * @ORM\Column(type="string", length=32, unique = true, options={"fixed" = true})
     *
     * @var int
     */
    protected $hash;

    /**
     * @return the $acta
     */
    public function getActa ()
    {
        return $this->acta;
    }

     /**
     * @return the $partido
     */
    public function getPartido ()
    {
        return $this->partido;
    }

     /**
     * @return the $hash
     */
    public function getHash ()
    {
        return $this->hash;
    }

     /**
     * @param field_type $acta
     */
    public function setActa ($acta)
    {
        $this->acta = $acta;
        return $this;
    }

     /**
     * @param field_type $partido
     */
    public function setPartido ($partido)
    {
        $this->partido = $partido;
        return $this;
    }

     /**
     * @param number $hash
     */
    public function setHash ($hash)
    {
        $this->hash = $hash;
        return $this;
    }
}