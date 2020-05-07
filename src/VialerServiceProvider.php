<?php

namespace Ajtarragona\Vialer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
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


        //idiomas
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'vialer');

        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/vendor/ajtarragona-vialer'),
        ], 'ajtarragona-vialer-translations');

         //registra directiva sortablecomponent
         Blade::directive('vialerFormControl',  function ($expression) {
            return "<?php echo vialerFormControl({$expression}); ?>";
        });


       
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
            return new \Ajtarragona\Vialer\Providers\VialerProvider;
        });

               
        $this->app->bind('catastro', function(){
            return new \Ajtarragona\Vialer\Providers\CatastroProvider;
        });

        

        $this->app->bind('districtes', function(){
            return new \Ajtarragona\Vialer\Providers\DistricteSeccioProvider;
        });

        



        //helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }
}
