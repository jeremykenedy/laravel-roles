<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Console\Concerns;

trait HandlesFrameworkSetup
{
    protected function setCssFramework(string $css): void
    {
        $this->updateEnvValue('ROLES_CSS_FRAMEWORK', $css);

        config(['roles.cssFramework' => $css]);

        $this->call('view:clear');
        $this->call('config:clear');
    }

    protected function updateEnvValue(string $key, string $value): void
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            return;
        }

        $content = file_get_contents($path);

        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            $content = rtrim($content, "\n")."\n{$key}={$value}\n";
        }

        file_put_contents($path, $content);
    }

    protected function packageIsInstalled(): bool
    {
        return file_exists(config_path('roles.php'));
    }
}
