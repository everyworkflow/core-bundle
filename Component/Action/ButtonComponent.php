<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Component\Action;

use EveryWorkflow\CoreBundle\Component\BaseComponent;

class ButtonComponent extends BaseComponent implements ButtonComponentInterface
{
    public function setLabel(string $label): ButtonComponentInterface
    {
        $this->dataObject->setData(self::KEY_LABEL, $label);
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->dataObject->getData(self::KEY_LABEL);
    }

    public function setUrl(string $url): ButtonComponentInterface
    {
        $this->dataObject->setData(self::KEY_URL, $url);
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->dataObject->getData(self::KEY_URL);
    }

    public function setCssClass(string $cssClass): ButtonComponentInterface
    {
        $this->dataObject->setData(self::KEY_CSS_CLASS, $cssClass);
        return $this;
    }

    public function getCssClass(): ?string
    {
        return $this->dataObject->getData(self::KEY_CSS_CLASS);
    }
}
