<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 10.10.16
 * Time: 17:24
 */

namespace Benkle\AutoPreflightBundle\Service;


use Symfony\Component\Routing\Router;

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
        return array_filter($methods);
    }

}
