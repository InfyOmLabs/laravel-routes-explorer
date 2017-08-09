<?php

namespace InfyOm\RoutesExplorer;

use InfyOm\RoutesExplorer\Models\ApiCallsCount;
use Route;

class RoutesExplorer
{
    public function getRoutes()
    {
        /** @var \Illuminate\Routing\Route[] $allRoutes */
        $allRoutes = Route::getRoutes()->getRoutes();

        /** @var \Illuminate\Routing\Route[] $allRoutes */
        $namedRoutes = Route::getRoutes()->getRoutesByName();

        $namedRoutesUri = [];
        foreach ($namedRoutes as $routeName => $route) {
            $namedRoutesUri[$route->uri] = $routeName;
        }

        $routes = [];
        foreach ($allRoutes as $route) {
            $routes[$route->uri] = [
                'name' => isset($namedRoutesUri[$route->uri]) ? $namedRoutesUri[$route->uri] : '',
                'url' => $route->uri,
                'methods' => implode(", ", $route->methods()),
                'count' => 0
            ];
        }

        if (config('infyom.routes_explorer.collections.api_calls_count')) {
            $apiCallCount = ApiCallsCount::groupBy('url')
                ->select('url', \DB::raw('count(*) as total'))
                ->get();

            foreach ($apiCallCount as $countObj) {
                $routes[$countObj->url]['count'] = $countObj->total;
            }
        }

        return $routes;
    }

    public function showRoutes()
    {
        $routes = $this->getRoutes();

        return view(config('infyom.routes_explorer.view'))->with(['routes' => $routes]);
    }
}