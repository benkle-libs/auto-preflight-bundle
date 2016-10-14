<?php
/**
 * Copyright (c) 2016 Benjamin Kleiner
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Benkle\AutoPreflightBundle\Listener;


use Benkle\AutoPreflightBundle\Service\RouteMethodService;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class ResponseListener
 * I prefer to handle events separately, even if that means I have more classes...
 * @package Benkle\AutoPreflightBundle\Listener
 */
class ResponseListener
{
    /** @var  RouteMethodService */
    private $rms;

    /** @var  array */
    private $config;

    /**
     * ResponseListener constructor.
     * @param RouteMethodService $rms
     * @param \string[] $allowOrigins
     * @param \string[] $allowHeaders
     */
    public function __construct(RouteMethodService $rms, array $config = [])
    {
        $this->rms = $rms;
        $this->config = $config;
    }

    /**
     * Handle Response events.
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $response = $event->getResponse();
        $methods = $this->rms->getMethodsForPath($event->getRequest()->getPathInfo());
        if (empty($methods)) { // nothing? There's always GET
            $methods = ['GET'];
        }
        $response->headers->set('Access-Control-Allow-Origin', $this->config['allow_origin']);
        $response->headers->set('Access-Control-Allow-Methods', implode(',', $methods));
        $response->headers->set('Access-Control-Allow-Headers', $this->config['allow_headers']);
    }

}
