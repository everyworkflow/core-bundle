<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Annotation;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Annotation class for @EWFRoute().
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class EWFRoute extends Route
{
    /**
     * @param $path
     */
    public function setAdminApiPath($path): void
    {
        parent::setPath('admin_api/' . $path);
    }

    public function getAdminApiPath(): void
    {
        $this->getPath();
    }

    public function setApiPath($path): void
    {
        parent::setPath('api/' . $path);
    }
}
