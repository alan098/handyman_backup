<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);




        Fortify::authenticateUsing(function (Request $request) {

            Log::info(__FILE__.'/'.__FUNCTION__); 

            $user = User::where('email', $request->email)->first();


            if ($user && Hash::check($request->password, $user->password)) {
                if($user->es_activo){
                    return $user;
                }else{
                    Log::info('no es activo');
                }
            }else{
                    Log::info('no machea usu y pass');
                    // Log::info($request->password.'!='.$user->password);


            }
        });


    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
