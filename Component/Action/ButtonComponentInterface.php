<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Component\Action;

use EveryWorkflow\CoreBundle\Component\BaseComponentInterface;

interface ButtonComponentInterface extends BaseComponentInterface
{
    public const KEY_CSS_CLASS = 'css_class';
    public const KEY_LABEL = 'label';
    public const KEY_URL = 'url';

    public function setLabel(string $label): self;

    public function getLabel(): ?string;

    public function setUrl(string $url): self;

    public function getUrl(): ?string;

    public function setCssClass(string $cssClass): self;

    public function getCssClass(): ?string;
}
