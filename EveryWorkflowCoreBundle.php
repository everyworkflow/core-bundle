<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle;

use EveryWorkflow\CoreBundle\DependencyInjection\CoreExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCoreBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CoreExtension();
    }
}
