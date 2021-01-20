<?php

namespace App\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    protected $modules = [];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        foreach($this->getModules() as $module) {
            $path = base_path('app/' . $module . '/Routes/channels.php');
            if(file_exists($path)) {
                require $path;
            }
        }
    }

    protected function getModules()
    {
        if(!$this->modules) {
            $path = base_path('app/');
            foreach(scandir($path) as $module) {
                if($module == '.' || $module == '..') {
                    continue;
                }

                $routesPath = base_path('app/' . $module . '/Routes/');
                if(!is_dir($routesPath)) {
                    continue;
                }

                $this->modules[] = $module;
            }
        }
        return $this->modules;
    }
}
