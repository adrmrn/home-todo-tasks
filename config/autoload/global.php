<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\Db\Adapter\AdapterServiceFactory;

return [
    'service_manager' => [
        'factories' => [
            Adapter::class => AdapterServiceFactory::class,
        ],
        'abstract_factories' => [
            AdapterAbstractServiceFactory::class,
        ],
    ],
];
