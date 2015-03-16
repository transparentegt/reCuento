<?php
namespace Recuento;

use Zend\ServiceManager\ServiceManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        $autoloader = array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
        return $autoloader;
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'Recuento\Repository\ActaRepository' => function (ServiceManager $sm) {
                    $em    = $sm->get('Doctrine\ORM\EntityManager');
                    $model = $em->getRepository('\Recuento\Entity\Acta');
                    return $model;
                },
                'Recuento\Repository\CaptchaRepository' => function (ServiceManager $sm) {
                    $em    = $sm->get('Doctrine\ORM\EntityManager');
                    $model = $em->getRepository('\Recuento\Entity\Captcha');
                    return $model;
                },
            ],
        ];
    }
}
