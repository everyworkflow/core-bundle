<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Helper;

use EveryWorkflow\CoreBundle\Annotation\EWFAnnotationReaderInterface;
use EveryWorkflow\CoreBundle\Cache\CacheInterface;
use EveryWorkflow\CoreBundle\Message\MessageInterface;
use Psr\Log\LoggerInterface;


class CoreHelper implements CoreHelperInterface
{
    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;
    /**
     * @var EWFAnnotationReaderInterface
     */
    private EWFAnnotationReaderInterface $EWFAnnotationReader;
    /**
     * @var MessageInterface
     */
    private MessageInterface $message;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CoreHelper constructor.
     * @param CacheInterface $cache
     * @param EWFAnnotationReaderInterface $EWFAnnotationReader
     * @param MessageInterface $message
     * @param LoggerInterface $logger
     */
    public function __construct(
        CacheInterface $cache,
        EWFAnnotationReaderInterface $EWFAnnotationReader,
        MessageInterface $message,
        LoggerInterface $logger
    ) {
        $this->cache = $cache;
        $this->EWFAnnotationReader = $EWFAnnotationReader;
        $this->message = $message;
        $this->logger = $logger;
    }

    /**
     * @return CacheInterface
     */
    public function getEWFCacheInterface(): CacheInterface
    {
        return $this->cache;
    }

    /**
     * @return EWFAnnotationReaderInterface
     */
    public function getEWFAnnotationReaderInterface(): EWFAnnotationReaderInterface
    {
        return $this->EWFAnnotationReader;
    }

    /**
     * @return MessageInterface
     */
    public function getMessageInterface(): MessageInterface
    {
        return $this->message;
    }

    /**
     * @return LoggerInterface
     */
    public function getLoggerInterface()
    {
        return $this->logger;
    }
}
