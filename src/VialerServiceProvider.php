<?php

namespace Ajtarragona\Vialer;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Blade;
//use Illuminate\Support\Facades\Schema;

class VialerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        

        //vistas
        $this->loadViewsFrom(__DIR__.'/resources/views', 'vialer');
        
        //cargo rutas
        $this->loadRoutesFrom(__DIR__.'/routes.php');


        //publico configuracion
        $config = __DIR__.'/Config/vialer.php';
        
        $this->publishes([
            $config => config_path('vialer.php'),
        ], 'ajtarragona-vialer-config');


        $this->mergeConfigFrom($config, 'vialer');


         //publico assets
        $this->publishes([
            __DIR__.'/public' => public_path('vendor/ajtarragona'),
        ], 'ajtarragona-vialer-assets');



       
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       	//registro middleware
        $this->app['router']->aliasMiddleware('vialer-backend', \Ajtarragona\Vialer\Middlewares\VialerBackend::class);

        //defino facades
        $this->app->bind('vialer', function(){
            return new \Ajtarragona\Vialer\Models\VialerProvider;
        });
        

        //helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }
}
