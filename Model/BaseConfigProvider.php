<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class BaseConfigProvider implements BaseConfigProviderInterface
{
    protected array $configs = [];

    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
    }

    /**
     * @param string|null $path
     * @return mixed
     */
    public function get(?string $path = null): mixed
    {
        $value = null;
        if ($path === null) {
            $value = $this->configs;
        } elseif (is_string($path)) {
            $indexes = explode('.', $path);
            foreach ($indexes as $index) {
                if ($value === null && isset($this->configs[$index])) {
                    $value = $this->configs[$index];
                } elseif (isset($value[$index])) {
                    $value = $value[$index];
                } else {
                    $value = null;
                    break;
                }
            }
        }

        return $value;
    }
}
