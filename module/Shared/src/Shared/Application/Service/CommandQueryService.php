<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 10.11.17
 * Time: 14:32
 */

namespace Shared\Application\Service;

use Shared\Application\CommandQuery\CommandQueryInterface;
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

    /**
     * @param string $commandQueryName
     * @param array  $arguments
     *
     * @return object
     */
    public function prepareCommandQuery(string $commandQueryName, array $arguments)
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
                // TODO: create ValidationException with error map
                throw new \InvalidArgumentException('Data for Command or Query seems to be invalid.', 422);
            }

            $tmpArguments = [];
            foreach ($arguments as $key => $value) {
                $tmpArguments[$key] = $inputFilter->getValues()[$key];
            }
            $arguments = $tmpArguments;
        }

        $commandQuery = $reflection->newInstanceArgs($arguments);

        return $commandQuery;
    }

    /**
     * @param string $commandQueryName
     *
     * @return bool
     */
    private function issetInputFilterForCommandQuery(string $commandQueryName): bool
    {
        return TRUE === isset($this->inputFilterMap[$commandQueryName]);
    }

    /**
     * @param string $commandQueryName
     *
     * @return \Zend\InputFilter\InputFilterInterface|\Zend\InputFilter\InputInterface
     */
    private function grabInputFilterForCommandQuery(string $commandQueryName)
    {
        $inputFilterClass = $this->inputFilterMap[$commandQueryName];

        if (FALSE === $this->inputFilterPluginManager->has($inputFilterClass)) {
            throw new \RuntimeException('InputFilter for Query or Command does not exist.', 501);
        }

        $inputFilter = $this->inputFilterPluginManager->get($inputFilterClass);

        return $inputFilter;
    }
}