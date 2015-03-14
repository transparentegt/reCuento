<?php
namespace Recuento\Controller;

use Zend\Mvc\Controller\AbstractActionController;
// use Zend\View\Model\ViewModel;
use Recuento\Entity\Acta;

class ActaController extends AbstractActionController
{
    /**
     * Acción para leer todos los documentos descargados para análisis
     */
    public function readAction()
    {
        foreach(Acta::$types as $type => $typeName) {
            $dir  = dirname(dirname(dirname(__DIR__))) . '/data/actas/';
            $dir  = new \DirectoryIterator($dir .  $type);
            $docs = [];
            foreach($dir as $file) {
                if (!$file->isFile()) continue;
                $id = (int) substr($file->getFilename(), 0, 5);
                $docs[$id] = $file->getPathname();
            }
            ksort($docs);
            $repository = $this->getServiceLocator()->get('Recuento\Repository\ActaRepository');
            /* @var $repository \Recuento\Repository\ActaRepository */
            foreach ($docs as $id => $doc) {
                $acta = $repository->find(['id' => $id, 'type' => $type]);
                if ($acta) continue;
                $acta = new \Recuento\Entity\Acta();
                $acta->setId($id)->setType($type);
                $size = getimagesize($doc);
                if ($size[0]) {
                    $acta->setWidth($size[0]);
                }
                if ($size[1]) {
                    $acta->setHeight($size[1]);
                }
                $repository->save($acta);
                echo "\nGuardando acta: ".$acta->getId();
            }
            unset($docs);
        }
    }
}