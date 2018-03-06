<?php

namespace MNC\Bundle\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Trait NoEditActionTrait
 * @package MNC\Bundle\RestBundle\Controller
 * @author Matías Navarro Carter <mnavarro@option.cl>
 */
trait NoEditActionTrait
{
    /**
     * @param Request $request
     * @param $id
     */
    public function editAction(Request $request, $id)
    {
        $route = $request->getPathInfo();
        throw new RouteNotFoundException("Route $route not found");
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function updateAction(Request $request, $id)
    {
        $route = $request->getPathInfo();
        throw new RouteNotFoundException("Route $route not found");
    }
}