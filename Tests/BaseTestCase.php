<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Tests;

use EveryWorkflow\CoreBundle\Model\DataObjectFactory;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseTestCase extends KernelTestCase
{
//    protected function getContainer(): ContainerInterface
//    {
//        $kernel = $this->bootKernel([]);
//        $container = $kernel->getContainer();
//        return $container;
//    }

    public function getDataObjectFactory(): DataObjectFactoryInterface
    {
        return new DataObjectFactory();
    }
}
