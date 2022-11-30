<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerViewAndRoute();
    }

    protected function registerViewAndRoute()
    {
        //view auto discovery
        $useTemplatePath = base_path('templates/' . env('TEMPLATE', 'default') . '/views');
        if (File::exists($useTemplatePath)) {
            View::addNamespace('template', $useTemplatePath);
            $files = scandir($useTemplatePath);
            $routes = $this->processRoutes($files);
            //route auto discovery
            app()->router->group([
                'namespace' => 'App\Http\Controllers',
            ], function ($router) use ($routes) {
                foreach ($routes as $k => $v) {
                    $router->get($k, function () use ($v) {
                        return view($v);
                    });
                }
            });
        }

    }

    protected function processRoutes(array $files): array
    {
        $routes = [];
        foreach ($files as $file) {
            if (strpos($file, '.blade.php')) {
                $name = str_replace('.blade.php', '', $file);

                if (strpos($name, 'common') || strpos($name, 'layouts') || strpos($name, 'errors')) {
                    continue;
                }

                switch ($name) {
                    case 'index':
                        $routes['/'] = "template::$name";
                        break;
                    default:
                        $name = str_replace($name, '/', '.'); //replace . with /
                        $name = "template::{$name}"; //add template namespace
                        $routes['/' . $name] = $name;
                        break;
                }
            }
        }
        return $routes;
    }
}
