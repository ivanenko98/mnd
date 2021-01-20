<?php

namespace App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use WFN\Admin\Model\Settings;

class Kernel extends ConsoleKernel
{

    protected $modules = [];

    protected function commands()
    {
        foreach ($this->getModules() as $module) {
            $path = base_path('app/' . $module . '/Commands');
            if(is_dir($path)) {
                $this->load($path);
            }

            $path_routes = base_path('app/' . $module . '/Routes/console.php');
            if(file_exists($path)) {
                require $path_routes;
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

                $routesPath = base_path('app/' . $module . '/Commands/');
                if (!is_dir($routesPath)) {
                    continue;
                }

                $this->modules[] = $module;
            }
        }
        return $this->modules;
    }

    protected function schedule(Schedule $schedule)
    {

    }
}
