<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 09.11.17
 * Time: 09:25
 */

use Shared\Infrastructure\Dao\DaoAbstractFactory;

return [
    'service_manager' => [
        'abstract_factories' => [
            DaoAbstractFactory::class,
        ],
    ],
];