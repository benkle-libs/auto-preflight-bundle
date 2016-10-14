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

namespace Benkle\AutoPreflightBundle\Service;


use Symfony\Component\Routing\Router;

/**
 * Class RouteMethodService
 * This service fetches all routes matching a path, and scans them for their HTTP methods.
 * @package Benkle\AutoPreflightBundle\Service
 */
class RouteMethodService
{
    /** @var Router  */
    private $router;

    /**
     * RequestListener constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Get HTTP methods available for a path.
     * @param string $pathInfo
     * @return string[]
     */
    public function getMethodsForPath($pathInfo)
    {
        $routes = $this->router->getRouteCollection()->all();
        $methods = [];
        foreach ($routes as $route) {
            $pattern = $route->compile()->getRegex();
            $x = $route->getOptions();
            if (preg_match($pattern, $pathInfo)) {
                $methods = array_merge($route->getMethods(), $methods);
            }
        }
        return array_filter(array_unique($methods));
    }

}
