<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // View login & register
        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.register'));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Default Fortify actions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // ==============================
        // FIX: Tambahkan Rate Limiter Login
        // ==============================
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        // ==============================
        // FIX: Rate Limiter Two-Factor
        // ==============================
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
            );
        });

        // ==============================
        // Redirect setelah LOGIN
        // ==============================
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            function () {
                return new class implements \Laravel\Fortify\Contracts\LoginResponse {
                    public function toResponse($request)
                    {
                        $user = auth()->user();
                        
                        if ($user->role === 'admin') {
                            return redirect('/admin/dashboard');
                        }
                        
                        // Buyer: cek apakah sudah punya customer profile
                        if ($user->customer) {
                            return redirect('/buyer/dashboard');
                        }
                        
                        // Belum punya profile, arahkan ke produk
                        return redirect('/product');
                    }
                };
            }
        );

        // ==============================
        // Redirect setelah REGISTER
        // ==============================
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            function () {
                return new class implements \Laravel\Fortify\Contracts\RegisterResponse {
                    public function toResponse($request)
                    {
                        // Buyer baru belum punya customer profile, arahkan ke produk
                        return redirect('/product')->with('success', 'Registrasi berhasil! Silakan belanja untuk membuat profil.');
                    }
                };
            }
        );
    }
}
