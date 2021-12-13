<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Tests\Doubles\Framework\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ContainerForTest implements ContainerInterface
{
    /**
     * @var string[]
     */
    public static $parameters;

    /**
     * @var object[]
     */
    public static $services;

    public function __construct(array $parameters = [], array $services = [])
    {
        self::$parameters = $parameters;
        self::$services = $services;
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, $service)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE)
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
}
