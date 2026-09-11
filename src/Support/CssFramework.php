<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Support;

class CssFramework
{
    public const BOOTSTRAP4 = 'bootstrap4';

    public const BOOTSTRAP5 = 'bootstrap5';

    public const TAILWIND = 'tailwind';

    /**
     * The frameworks the package ships a view set for.
     *
     * @return array<int, string>
     */
    public static function supported()
    {
        return [self::BOOTSTRAP4, self::BOOTSTRAP5, self::TAILWIND];
    }

    /**
     * Human readable labels, keyed by framework.
     *
     * @return array<string, string>
     */
    public static function labels()
    {
        return [
            self::TAILWIND   => 'Tailwind CSS',
            self::BOOTSTRAP5 => 'Bootstrap 5',
            self::BOOTSTRAP4 => 'Bootstrap 4',
        ];
    }

    /**
     * Determine whether the given value names a shipped view set.
     *
     * @param mixed $framework
     * @return bool
     */
    public static function isSupported($framework)
    {
        return is_string($framework) && in_array($framework, self::supported(), true);
    }

    /**
     * The framework the GUI should render.
     *
     * Falls back to Bootstrap 4 for unknown values so an upgrade or a typo
     * never leaves the GUI without views.
     *
     * @return string
     */
    public static function resolve()
    {
        if (config('roles.uiKit.enabled') && self::isSupported(config('ui-kit.css_framework'))) {
            return config('ui-kit.css_framework');
        }

        $framework = config('roles.cssFramework', self::BOOTSTRAP4);

        return self::isSupported($framework) ? $framework : self::BOOTSTRAP4;
    }

    /**
     * Absolute path to a framework's view directory.
     *
     * @param string $framework
     * @return string
     */
    public static function viewPath($framework)
    {
        return dirname(__DIR__).'/resources/views/'.$framework;
    }
}
