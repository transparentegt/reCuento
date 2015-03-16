<?php
namespace Recuento\Controller;

use Zend\Mvc\Controller\AbstractActionController;
// use Zend\View\Model\ViewModel;
use Recuento\Entity\Acta;
use Recuento\Entity\Captcha;

class ActaController extends AbstractActionController
{
    private function actas()
    {
        foreach(Acta::$types as $type => $typeName) {
            $dir  = dirname(dirname(dirname(__DIR__))) . '/data/actas/';
            $dir  = new \DirectoryIterator($dir .  $type);
            $docs = [];
            foreach($dir as $file) {
                if (!$file->isFile()) continue;
                $ext = substr($file->getFilename(), -3);
                if ($ext != 'jpg') continue;
                $id = (int) substr($file->getFilename(), 0, 5);
                $docs[$id] = $file->getPathname();
            }
            ksort($docs);
            $repository = $this->getServiceLocator()->get('Recuento\Repository\ActaRepository');
            /* @var $repository \Recuento\Repository\ActaRepository */
            foreach ($docs as $id => $doc) {
                $acta = $repository->findOneBy(['mesa' => $id, 'type' => $type]);
                if ($acta) continue;
                $acta = new \Recuento\Entity\Acta();
                $acta->setMesa($id)->setType($type);
                $size = getimagesize($doc);
                if ($size) {
                    $acta->setWidth($size[0]);
                    $acta->setHeight($size[1]);
                }
                $repository->save($acta);
                echo "\nGuardando acta: ".$acta->getId();
            }
            unset($docs);
        }
    }

    private function captchas()
    {
        $partidosList = [
            60 => 'PP',
            57 => 'P A N',
            67 => 'UCN',
            72 => 'UNIONISTA',
            41 => 'CREO',
            51 => 'LIDER',
            79 => 'WINAQ-ANN',
             1 => 'ADN',
             5 => 'CASA',
            77 => 'VIVA-EG',
        ];
        $actas    = $this->getServiceLocator()->get('Recuento\Repository\ActaRepository');
        /* @var $actas \Recuento\Repository\ActaRepository */
        $captchas = $this->getServiceLocator()->get('Recuento\Repository\CaptchaRepository');
        /* @var $captchas \Recuento\Repository\CaptchaRepository */
        $partidos = $this->getServiceLocator()->get('Transparente\Model\PartidoPoliticoModel');
        /* @var $partidos \Transparente\Model\PartidoPoliticoModel */

        $actas    = $actas->findBy([
            'width'  => 1700,
            'height' => 2200,
            'type'   => \Recuento\Entity\Acta::TYPE_PRESIDENT,
        ], ['id' => 'ASC']);
        foreach ($actas as $acta) {
            $imagePath = $acta->getImage();
            $height    = 63;
            $offset    = 735 -$height;
            $i = 0;
            foreach ($partidosList as $partidoId => $partido) {
                $offset += $height;
                $hash    = md5("{$acta->getId()}_$partidoId");
                $target  = dirname($imagePath) . "/captchas/$hash.png";
                exec("convert -crop 300x$height+700+$offset $imagePath $target");
                $target  = dirname($imagePath) . "/captchas-debug/{$acta->getMesa()}-{$partidoId}-$hash.png";
                exec("convert -crop 300x$height+700+$offset $imagePath $target");
                $captcha = new Captcha();
                $captcha->setHash($hash)
                        ->setActa($acta)
                        ->setPartido($partidos->find($partidoId));
                $captchas->save($captcha);
            }
        }
    }

    /**
     * Acción para leer todos los documentos descargados para análisis
     */
    public function readAction()
    {
        // $this->actas();
        $this->captchas();
    }
}