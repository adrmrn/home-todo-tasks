<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.11.17
 * Time: 14:32
 */

namespace Shared\Application\Service;

use Shared\Application\CommandQuery\CommandQueryInterface;
use Shared\Application\Exception\ValidationException;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterPluginManager;

class CommandQueryService
{
    /**
     * @var \Zend\InputFilter\InputFilterPluginManager
     */
    private $inputFilterPluginManager;
    /**
     * @var array
     */
    private $inputFilterMap;

    /**
     * CommandQueryService constructor.
     *
     * @param \Zend\InputFilter\InputFilterPluginManager $inputFilterPluginManager
     * @param array                                      $inputFilterMap
     */
    public function __construct(InputFilterPluginManager $inputFilterPluginManager, array $inputFilterMap = [])
    {
        $this->inputFilterPluginManager = $inputFilterPluginManager;
        $this->inputFilterMap           = $inputFilterMap;
    }

    public function prepareCommandQuery(string $commandQueryName, array $arguments): CommandQueryInterface
    {
        if (FALSE === class_exists($commandQueryName)) {
            throw new \RuntimeException('Command or Query does not exist.', 501);
        }

        $reflection = new \ReflectionClass($commandQueryName);

        if (FALSE === $reflection->implementsInterface(CommandQueryInterface::class)) {
            throw new \RuntimeException('Class is not Command or Query.', 501);
        }

        if (FALSE === empty($arguments) && TRUE === $this->issetInputFilterForCommandQuery($commandQueryName)) {
            $inputFilter = $this->grabInputFilterForCommandQuery($commandQueryName);
            $inputFilter->setData($arguments);

            if (FALSE === $inputFilter->isValid()) {
                $exception = new ValidationException('Data for Command or Query seems to be invalid.', 422);
                $exception->setAdditionalDetails([
                    'messages' => $inputFilter->getMessages(),
                ]);
                throw $exception;
            }

            $tmpArguments = [];
            foreach ($arguments as $key => $value) {
                $tmpArguments[$key] = $inputFilter->getValues()[$key];
            }
            $arguments = $tmpArguments;
        }

        $commandQuery = $reflection->newInstanceArgs($arguments);

        /** @var CommandQueryInterface $commandQuery */
        return $commandQuery;
    }

    private function issetInputFilterForCommandQuery(string $commandQueryName): bool
    {
        return TRUE === isset($this->inputFilterMap[$commandQueryName]);
    }

    private function grabInputFilterForCommandQuery(string $commandQueryName): InputFilterInterface
    {
        $inputFilterClass = $this->inputFilterMap[$commandQueryName];

        if (FALSE === $this->inputFilterPluginManager->has($inputFilterClass)) {
            throw new \RuntimeException('InputFilter for Query or Command does not exist.', 501);
        }

        $inputFilter = $this->inputFilterPluginManager->get($inputFilterClass);

        return $inputFilter;
    }
}