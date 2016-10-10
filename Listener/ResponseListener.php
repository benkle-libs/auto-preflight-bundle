<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 10.10.16
 * Time: 17:26
 */

namespace Benkle\AutoPreflightBundle\Listener;


use Benkle\AutoPreflightBundle\Service\RouteMethodService;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
    /** @var  RouteMethodService */
    private $rms;

    /**
     * ResponseListener constructor.
     * @param RouteMethodService $rms
     */
    public function __construct(RouteMethodService $rms)
    {
        $this->rms = $rms;
    }


    public function onKernelResponse(FilterResponseEvent $event) {
        if (!$event->isMasterRequest()) {
            return;
        }
        $response = $event->getResponse();
        $methods = $this->rms->getMethodsForPath($event->getRequest()->getPathInfo());
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', implode(',', $methods));
        $response->headers->set('Access-Control-Allow-Headers', 'X-Header-One,X-Header-Two');
    }

}
