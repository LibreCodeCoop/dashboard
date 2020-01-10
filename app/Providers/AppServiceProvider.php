<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class, function () {
            return \Faker\Factory::create('pt_BR');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($value) {
            return "<?php echo number_format($value, 2, ',', '.'); ?>";
        });

        Blade::directive('totalduration', function ($value) {
            return "<?php echo str_pad((int)($value/60), 2, 0, STR_PAD_LEFT), ($value%60!=0? ':'.str_pad($value%60, 2, 0, STR_PAD_LEFT) : ':00'); ?>";
        });
    }
}
