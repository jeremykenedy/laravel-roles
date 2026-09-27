<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Console;

use Illuminate\Console\Command;
use jeremykenedy\LaravelRoles\App\Console\Concerns\HandlesFrameworkSetup;
use jeremykenedy\LaravelRoles\App\Console\Concerns\HasInstallPrompts;

class InstallCommand extends Command
{
    use HandlesFrameworkSetup;
    use HasInstallPrompts;

    protected $signature = 'roles:install
        {--css= : CSS framework (bootstrap4, bootstrap5, tailwind)}
        {--force : Skip the confirmation shown when already installed}';

    protected $description = 'Install Laravel Roles and choose which CSS framework the GUI uses';

    public function handle(): int
    {
        $this->renderBanner('roles');

        if ($this->packageIsInstalled() && !$this->confirmReinstall()) {
            return self::FAILURE;
        }

        $css = $this->promptFramework();

        if ($css === false) {
            return self::FAILURE;
        }

        $this->call('vendor:publish', [
            '--tag'   => 'laravelroles-config',
            '--force' => true,
        ]);

        $this->setCssFramework($css);
        $this->showSummary('installed', $css);

        return self::SUCCESS;
    }

    private function confirmReinstall(): bool
    {
        if ($this->option('force')) {
            return true;
        }

        $this->warn('  Laravel Roles is already installed.');
        $this->line('  Run <info>php artisan roles:update</info> to change the CSS framework safely.');
        $this->line('  Reinstalling overwrites config/roles.php.');
        $this->newLine();

        if ($this->option('no-interaction')) {
            $this->error('Already installed. Pass --force to reinstall.');

            return false;
        }

        if ($this->ask('Type "yes" to reinstall') !== 'yes') {
            $this->info('  Cancelled. No changes were made.');

            return false;
        }

        return true;
    }
}
