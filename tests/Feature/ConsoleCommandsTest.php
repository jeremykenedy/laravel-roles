<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Support\CssFramework;

/**
 * Point the application at a scratch directory so the commands never write
 * config or .env files into the testbench skeleton.
 */
function useScratchAppPath(): string
{
    $path = sys_get_temp_dir().'/laravel-roles-'.uniqid();

    mkdir($path.'/config', 0777, true);
    app()->setBasePath($path);

    return $path;
}

function markInstalled(string $path): void
{
    file_put_contents($path.'/config/roles.php', '<?php return [];');
}

afterEach(function (): void {
    if (isset($this->scratchPath) && is_dir($this->scratchPath)) {
        exec('rm -rf '.escapeshellarg($this->scratchPath));
    }
});

it('registers the three package commands', function (): void {
    $commands = array_keys(app('Illuminate\Contracts\Console\Kernel')->all());

    expect($commands)->toContain('roles:install', 'roles:update', 'roles:switch');
});

describe('roles:switch', function () {
    it('switches to each supported framework', function (string $framework): void {
        $this->scratchPath = useScratchAppPath();

        $this->artisan('roles:switch', ['--css' => $framework])
            ->assertSuccessful();

        expect(config('roles.cssFramework'))->toBe($framework);
    })->with(CssFramework::supported());

    it('fails without a framework', function (): void {
        $this->scratchPath = useScratchAppPath();

        $this->artisan('roles:switch')
            ->expectsOutputToContain('Pass --css with one of')
            ->assertFailed();
    });

    it('rejects an unsupported framework', function (): void {
        $this->scratchPath = useScratchAppPath();

        $this->artisan('roles:switch', ['--css' => 'bulma'])
            ->expectsOutputToContain('Invalid CSS framework: bulma')
            ->assertFailed();

        expect(config('roles.cssFramework'))->not->toBe('bulma');
    });

    it('writes the framework into the env file', function (): void {
        $this->scratchPath = useScratchAppPath();
        file_put_contents($this->scratchPath.'/.env', "APP_ENV=testing\n");

        $this->artisan('roles:switch', ['--css' => 'tailwind'])->assertSuccessful();

        expect(file_get_contents($this->scratchPath.'/.env'))
            ->toContain('ROLES_CSS_FRAMEWORK=tailwind');
    });

    it('replaces an existing framework entry rather than appending', function (): void {
        $this->scratchPath = useScratchAppPath();
        file_put_contents($this->scratchPath.'/.env', "ROLES_CSS_FRAMEWORK=bootstrap4\n");

        $this->artisan('roles:switch', ['--css' => 'bootstrap5'])->assertSuccessful();

        $env = file_get_contents($this->scratchPath.'/.env');

        expect($env)->toContain('ROLES_CSS_FRAMEWORK=bootstrap5')
            ->and(substr_count($env, 'ROLES_CSS_FRAMEWORK='))->toBe(1);
    });
});

describe('roles:install', function () {
    it('installs with each supported framework', function (string $framework): void {
        $this->scratchPath = useScratchAppPath();

        $this->artisan('roles:install', ['--css' => $framework, '--force' => true])
            ->assertSuccessful();

        expect(config('roles.cssFramework'))->toBe($framework);
    })->with(CssFramework::supported());

    it('rejects an unsupported framework', function (): void {
        $this->scratchPath = useScratchAppPath();

        $this->artisan('roles:install', ['--css' => 'bulma', '--force' => true])
            ->expectsOutputToContain('Invalid CSS framework: bulma')
            ->assertFailed();
    });

    it('refuses to reinstall without force when already installed', function (): void {
        $this->scratchPath = useScratchAppPath();
        markInstalled($this->scratchPath);

        $this->artisan('roles:install', ['--css' => 'tailwind', '--no-interaction' => true])
            ->expectsOutputToContain('Already installed')
            ->assertFailed();
    });

    it('reinstalls when force is passed', function (): void {
        $this->scratchPath = useScratchAppPath();
        markInstalled($this->scratchPath);

        $this->artisan('roles:install', ['--css' => 'bootstrap5', '--force' => true])
            ->assertSuccessful();

        expect(config('roles.cssFramework'))->toBe('bootstrap5');
    });
});

describe('roles:update', function () {
    it('updates each supported framework when installed', function (string $framework): void {
        $this->scratchPath = useScratchAppPath();
        markInstalled($this->scratchPath);

        $this->artisan('roles:update', ['--css' => $framework])
            ->assertSuccessful();

        expect(config('roles.cssFramework'))->toBe($framework);
    })->with(CssFramework::supported());

    it('fails when the package is not installed', function (): void {
        $this->scratchPath = useScratchAppPath();

        $this->artisan('roles:update', ['--css' => 'tailwind'])
            ->expectsOutputToContain('not installed yet')
            ->assertFailed();
    });

    it('rejects an unsupported framework', function (): void {
        $this->scratchPath = useScratchAppPath();
        markInstalled($this->scratchPath);

        $this->artisan('roles:update', ['--css' => 'bulma'])
            ->expectsOutputToContain('Invalid CSS framework: bulma')
            ->assertFailed();
    });
});
