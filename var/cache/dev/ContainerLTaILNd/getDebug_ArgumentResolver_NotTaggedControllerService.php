<?php

namespace ContainerLTaILNd;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDebug_ArgumentResolver_NotTaggedControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'debug.argument_resolver.not_tagged_controller' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver\TraceableValueResolver
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'http-kernel'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'ArgumentValueResolverInterface.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'http-kernel'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'ArgumentResolver'.\DIRECTORY_SEPARATOR.'TraceableValueResolver.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'http-kernel'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'ArgumentResolver'.\DIRECTORY_SEPARATOR.'NotTaggedControllerValueResolver.php';

        return $container->privates['debug.argument_resolver.not_tagged_controller'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\TraceableValueResolver(new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\NotTaggedControllerValueResolver(($container->privates['.service_locator.0LURLUV'] ?? $container->load('get_ServiceLocator_0LURLUVService'))), ($container->privates['debug.stopwatch'] ?? ($container->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }
}
