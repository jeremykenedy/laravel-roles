<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Console;

use Illuminate\Console\Command;
use jeremykenedy\LaravelRoles\App\Console\Concerns\HandlesFrameworkSetup;
use jeremykenedy\LaravelRoles\Support\CssFramework;

class SwitchCommand extends Command
{
    use HandlesFrameworkSetup;

    protected $signature = 'roles:switch
        {--css= : CSS framework (bootstrap4, bootstrap5, tailwind)}';

    protected $description = 'Switch the Laravel Roles GUI to another CSS framework';

    public function handle(): int
    {
        $css = $this->option('css');

        if (!$css) {
            $this->error('Pass --css with one of: '.implode(', ', CssFramework::supported()));
            $this->line('Example: <info>php artisan roles:switch --css=bootstrap5</info>');

            return self::FAILURE;
        }

        if (!CssFramework::isSupported($css)) {
            $this->error("Invalid CSS framework: {$css}. Use: ".implode(', ', CssFramework::supported()));

            return self::FAILURE;
        }

        $this->setCssFramework($css);

        $this->info('Laravel Roles GUI switched to '.CssFramework::labels()[$css].'.');

        if (file_exists(base_path('resources/views/vendor/laravelroles'))) {
            $this->warn('Published views in resources/views/vendor/laravelroles still override the package.');
            $this->line('Republish them with: <info>php artisan vendor:publish --tag=laravelroles-views-'.$css.' --force</info>');
        }

        return self::SUCCESS;
    }
}
