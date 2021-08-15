<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Helper;

interface CoreHelperInterface
{
    public function getEWFCacheInterface();
    public function getEWFAnnotationReaderInterface();
    public function getMessageInterface();
    public function getLoggerInterface();
}
