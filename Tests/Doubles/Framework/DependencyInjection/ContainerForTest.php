<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Framework\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ScopeInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ContainerForTest implements ContainerInterface
{
    public const SCOPE_CONTAINER_TEST = 'container';

    /**
     * @var string[]
     */
    public static $parameters;

    /**
     * @var object[]
     */
    public static $services;

    public function __construct(array $parameters = [], array $services = [], $scope = self::SCOPE_CONTAINER_TEST)
    {
        self::$parameters = $parameters;
        self::$services = $services;
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, $service, $scope = self::SCOPE_CONTAINER_TEST)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        return self::$services[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function initialized($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        return self::$parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function enterScope($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function addScope(ScopeInterface $scope)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function leaveScope($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function hasScope($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isScopeActive($name)
    {
    }
}
