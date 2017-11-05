<?php

namespace Api\V1\Rpc\Health;

use Zend\Mvc\Controller\AbstractActionController;

class HealthController extends AbstractActionController
{
    public function healthAction()
    {
        return ['status' => 'ok'];
    }
}
