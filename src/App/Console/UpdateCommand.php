<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Console;

use Illuminate\Console\Command;
use jeremykenedy\LaravelRoles\App\Console\Concerns\HandlesFrameworkSetup;
use jeremykenedy\LaravelRoles\App\Console\Concerns\HasInstallPrompts;

class UpdateCommand extends Command
{
    use HandlesFrameworkSetup;
    use HasInstallPrompts;

    protected $signature = 'roles:update
        {--css= : CSS framework (bootstrap4, bootstrap5, tailwind)}';

    protected $description = 'Change the CSS framework the Laravel Roles GUI uses without touching config or published views';

    public function handle(): int
    {
        $this->renderBanner('roles');

        if (!$this->packageIsInstalled()) {
            $this->warn('  Laravel Roles is not installed yet.');
            $this->line('  Run <info>php artisan roles:install</info> first.');

            return self::FAILURE;
        }

        $css = $this->promptFramework();

        if ($css === false) {
            return self::FAILURE;
        }

        $this->setCssFramework($css);
        $this->showSummary('updated', $css);

        return self::SUCCESS;
    }
}
