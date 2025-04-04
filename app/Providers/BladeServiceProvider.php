<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use BenSampo\Enum\Enum;
use App\Attributes\Icon;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('svg', function ($arguments) {
            // Funky madness to accept multiple arguments into the directive
            [$path, $class] = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path  = str_replace('/', '.', trim($path, "' "));
            $class = trim($class, "' ");

            if (Str::startsWith($path, '$')) {
                return <<<EOT
                            {!! get_svg($path, '$class') !!}
                    EOT;
            }

            return get_svg($path, $class);
        });

        Enum::macro('getAttributeIcon', function (mixed $value) {
            $reflection      = self::getReflection();
            $constantName    = static::getKey($value);
            $constReflection = $reflection->getReflectionConstant($constantName);
            if ($constReflection === false) {
                return null;
            }

            $iconAttributes = $constReflection->getAttributes(Icon::class);

            return match (count($iconAttributes)) {
                0       => null,
                1       => $iconAttributes[0]->newInstance()->icon,
                default => throw new \Exception('You cannot use more than 1 description attribute on ' . class_basename(static::class) . '::' . $constantName),
            };
        });
    }
}
