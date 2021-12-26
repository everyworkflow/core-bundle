<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Tests;

use EveryWorkflow\CoreBundle\Factory\ValidationTypeFactory;
use EveryWorkflow\CoreBundle\Factory\ValidatorFactory;
use EveryWorkflow\CoreBundle\Factory\ValidatorFactoryInterface;
use EveryWorkflow\CoreBundle\Model\CoreConfigProvider;
use EveryWorkflow\CoreBundle\Model\CoreConfigProviderInterface;
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

    public function getCoreConfigProvider(): CoreConfigProviderInterface
    {
        return new CoreConfigProvider($this->getContainer()->getParameter('core'));
    }

    protected function getValidatorFactory(): ValidatorFactoryInterface
    {
        $validationTypeFactory = new ValidationTypeFactory(
            $this->getContainer(),
            $this->getCoreConfigProvider(),
            $this->getDataObjectFactory()
        );
        return new ValidatorFactory($validationTypeFactory);
    }
}
