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
            foreach($dir as $key => $file) {
                if (!$file->isFile()) continue;
                $id = (int) substr($file->getFilename(), 0, 5);
                $docs[$id] = $file->getPathname();
            }
            ksort($docs);
            echo '<pre><strong>Debug::</strong>'.__FILE__.' +'.__LINE__.' -  '; var_dump($docs); die();
            die();

        }
    }
}