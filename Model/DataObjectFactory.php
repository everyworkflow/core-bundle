<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class DataObjectFactory implements DataObjectFactoryInterface
{
    public function create(array $data = []): DataObjectInterface
    {
        return new DataObject($data);
    }
}
