<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 10.10.16
 * Time: 16:48
 */

namespace Benkle\AutoPreflightBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        $method = $request->getRealMethod();
        if ('OPTIONS' == $method) {
            $response = new Response();
            $event->setResponse($response);
        }
    }

}
