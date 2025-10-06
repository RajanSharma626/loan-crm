<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('inr', function ($expression) {
            return "<?php echo '₹ ' . \\App\\Providers\\AppServiceProvider::formatIndianNumber($expression); ?>";
        });
    }

    public static function formatIndianNumber($number): string
    {
        if ($number === null || $number === '') {
            return '0';
        }
        $negative = $number < 0;
        $number = abs((float)$number);
        $parts = explode('.', number_format($number, 2, '.', ''));
        $integer = $parts[0];
        $decimal = $parts[1] ?? '00';

        $len = strlen($integer);
        if ($len <= 3) {
            $formattedInt = $integer;
        } else {
            $last3 = substr($integer, -3);
            $rest = substr($integer, 0, $len - 3);
            $rest = preg_replace('/\B(?=(?:\d{2})+(?!\d))/', ',', $rest);
            $formattedInt = $rest . ',' . $last3;
        }

        $result = $formattedInt;
        if ($decimal !== '00') {
            $result .= '.' . $decimal;
        }
        if ($negative) {
            $result = '-' . $result;
        }
        return $result;
    }
}
