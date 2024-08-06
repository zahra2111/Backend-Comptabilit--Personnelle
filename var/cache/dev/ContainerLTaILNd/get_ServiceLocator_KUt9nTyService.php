<?php

namespace ContainerLTaILNd;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_KUt9nTyService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.KUt9nTy' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.KUt9nTy'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'bank' => ['privates', '.errored..service_locator.KUt9nTy.App\\Entity\\Bank', NULL, 'Cannot autowire service ".service_locator.KUt9nTy": it references class "App\\Entity\\Bank" but no such service exists.'],
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
        ], [
            'bank' => 'App\\Entity\\Bank',
            'entityManager' => '?',
        ]);
    }
}