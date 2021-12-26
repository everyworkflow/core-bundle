<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\CoreBundle\EventListener;

use EveryWorkflow\CoreBundle\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class KernelExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidatorException) {
            $validator = $exception->getValidator();
            if ($validator) {
                $event->setResponse(new JsonResponse([
                    'title' => 'An error occurred',
                    'status' => 400,
                    'detail' => $exception->getMessage(),
                    'errors' => $validator->getAllErrors(),
                ], Response::HTTP_BAD_REQUEST));
            }
        }
    }
}
