<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 04.12.17
 * Time: 14:05
 */

namespace Cli\Controller;


use User\Application\Event\WorkerReceiver;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Zend\Mvc\Controller\AbstractActionController;

class UserEventReceiverController extends AbstractConsoleController
{
    /**
     * @var \User\Application\Event\WorkerReceiver
     */
    private $workerReceiver;

    /**
     * UserEventReceiverController constructor.
     *
     * @param \User\Application\Event\WorkerReceiver $workerReceiver
     */
    public function __construct(WorkerReceiver $workerReceiver)
    {
        $this->workerReceiver = $workerReceiver;
    }

    public function receiveEventAction()
    {
        $this->workerReceiver->listen();
    }
}