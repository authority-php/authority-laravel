<?php
namespace Authority\AuthorityLaravel;

use Authority\Authority;
use Illuminate\Support\ServiceProvider;

class AuthorityLaravelServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){
        $this->package('authority-php/authority-laravel');

        $this->app['authority'] = $this->app->share(function($app){
            $user = $app['auth']->user();
            $authority = new Authority($user);
            $fn = $app['config']->get('authority-laravel::initialize', null);

            if($fn) {
                $fn($authority);
            }

            return $authority;
        });

        $this->app->alias('authority', 'Authority\Authority');
    }

}
