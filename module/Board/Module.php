<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 29.01.18
 * Time: 19:20
 */

namespace Board;


use Board\Infrastructure\Doctrine\Type\MemberRoleType;
use Doctrine\DBAL\Types\Type;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface|\Zend\Mvc\MvcEvent $e
     *
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        Type::addType(MemberRoleType::NAME, MemberRoleType::class);
//        Type::addType('member_role', 'Board\Infrastructure\Doctrine\Type\MemberRoleType');

        return [];
    }
}