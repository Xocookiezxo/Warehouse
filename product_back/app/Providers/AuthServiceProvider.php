<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Auth;
use Firebase;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Auth::viaRequest('firebase', function ($request) {
            try {
                $token = $request->bearerToken();
                if ($token) {
                    $token = Firebase::auth()->verifyIdToken($token);
                    $uid = $token->claims()->get('sub');

                    $user = User::whereUid($uid)->first();

                    return  $user;
                }
            } catch (FailedToVerifyToken $e) {
                // echo 'The token is invalid: '.$e->getMessage();
                report($e);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            } catch (\Exception $e) {
                throw $e;
            }
        });
    }
}
