<?php

namespace MNC\Bundle\RestBundle\EventListener;

use MNC\Bundle\RestBundle\ApiProblem\ApiError;
use MNC\Bundle\RestBundle\ApiProblem\ApiProblem;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class RequestBodyListener
 * @package MNC\Bundle\RestBundle\EventListener
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
class RequestBodyListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();
        if ($request->isMethod('GET') OR !$content OR $request->headers->get('Content-Type') !== 'application/json') {
            return;
        }

        $data = json_decode($content, true);

        if (!$data) {
            $error = json_last_error_msg();
            $apiProblem = ApiProblem::create(422, $error, ApiError::TYPE_INVALID_REQUEST_BODY_FORMAT);
            $apiProblem->throwException();
        }

        foreach ($data as $key => $value) {
            $request->request->set($key, $value);
        }
    }
}