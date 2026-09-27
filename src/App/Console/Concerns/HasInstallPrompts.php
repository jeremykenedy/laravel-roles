<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Console\Concerns;

use jeremykenedy\LaravelRoles\Support\CssFramework;

trait HasInstallPrompts
{
    protected static $font = [
        'A' => ['  ██  ', ' ████ ', '██  ██', '██████', '██  ██'],
        'B' => ['█████ ', '██  ██', '█████ ', '██  ██', '█████ '],
        'C' => [' ████ ', '██    ', '██    ', '██    ', ' ████ '],
        'D' => ['████  ', '██  ██', '██  ██', '██  ██', '████  '],
        'E' => ['██████', '██    ', '████  ', '██    ', '██████'],
        'F' => ['██████', '██    ', '████  ', '██    ', '██    '],
        'G' => [' ████ ', '██    ', '██ ███', '██  ██', ' ████ '],
        'H' => ['██  ██', '██  ██', '██████', '██  ██', '██  ██'],
        'I' => ['██████', '  ██  ', '  ██  ', '  ██  ', '██████'],
        'J' => ['   ███', '    ██', '    ██', '██  ██', ' ████ '],
        'K' => ['██  ██', '██ ██ ', '████  ', '██ ██ ', '██  ██'],
        'L' => ['██    ', '██    ', '██    ', '██    ', '██████'],
        'M' => ['██   ██', '███ ███', '██ █ ██', '██   ██', '██   ██'],
        'N' => ['██  ██', '███ ██', '██████', '██ ███', '██  ██'],
        'O' => [' ████ ', '██  ██', '██  ██', '██  ██', ' ████ '],
        'P' => ['█████ ', '██  ██', '█████ ', '██    ', '██    '],
        'Q' => [' ████ ', '██  ██', '██  ██', '██ ██ ', ' ██ ██'],
        'R' => ['█████ ', '██  ██', '█████ ', '██ ██ ', '██  ██'],
        'S' => [' ████ ', '██    ', ' ████ ', '    ██', ' ████ '],
        'T' => ['██████', '  ██  ', '  ██  ', '  ██  ', '  ██  '],
        'U' => ['██  ██', '██  ██', '██  ██', '██  ██', ' ████ '],
        'V' => ['██  ██', '██  ██', '██  ██', ' ████ ', '  ██  '],
        'W' => ['██   ██', '██   ██', '██ █ ██', '███ ███', '██   ██'],
        'X' => ['██  ██', ' ████ ', '  ██  ', ' ████ ', '██  ██'],
        'Y' => ['██  ██', ' ████ ', '  ██  ', '  ██  ', '  ██  '],
        'Z' => ['██████', '   ██ ', '  ██  ', ' ██   ', '██████'],
        '-' => ['      ', '      ', ' ████ ', '      ', '      '],
        ' ' => ['   ', '   ', '   ', '   ', '   '],
    ];

    /**
     * Provided by Illuminate\Console\Command.
     *
     * @param string|null $key
     *
     * @return mixed
     */
    abstract public function option($key = null);

    /**
     * Provided by Illuminate\Console\Command.
     *
     * @param string          $string
     * @param string|null     $style
     * @param int|string|null $verbosity
     *
     * @return void
     */
    abstract public function line($string, $style = null, $verbosity = null);

    /**
     * Provided by Illuminate\Console\Command.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    abstract public function info($string, $verbosity = null);

    /**
     * Provided by Illuminate\Console\Command.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    abstract public function error($string, $verbosity = null);

    /**
     * Provided by Illuminate\Console\Command.
     *
     * @param int $count
     *
     * @return void
     */
    abstract public function newLine($count = 1);

    /**
     * Provided by Illuminate\Console\Command.
     *
     * @param string   $question
     * @param mixed    $default
     * @param int|null $attempts
     * @param bool     $multiple
     *
     * @return mixed
     */
    abstract public function choice($question, array $choices, $default = null, $attempts = null, $multiple = false);

    protected function renderBanner(string $name): void
    {
        $lines = ['', '', '', '', ''];

        foreach (str_split(strtoupper($name)) as $char) {
            $glyph = self::$font[$char] ?? self::$font[' '];
            for ($i = 0; $i < 5; $i++) {
                $lines[$i] .= $glyph[$i].' ';
            }
        }

        $palettes = [
            ['34', '35', '94', '95', '96'],
            ['31', '91', '33', '93', '31'],
            ['32', '92', '36', '96', '32'],
            ['33', '93', '91', '31', '33'],
            ['35', '95', '34', '94', '35'],
            ['36', '96', '92', '32', '36'],
            ['91', '93', '92', '96', '94'],
            ['95', '35', '34', '94', '96'],
        ];
        $colors = $palettes[array_rand($palettes)];

        $this->newLine();

        foreach ($lines as $i => $line) {
            $color = $colors[$i % count($colors)];
            $this->line("  \033[{$color}m{$line}\033[0m");
        }

        $this->newLine();
    }

    /**
     * Run the framework selection flow, returning false when the user cancels.
     *
     * @return string|false
     */
    protected function promptFramework()
    {
        $css = $this->option('css');

        if ($css) {
            return $this->validateFramework($css);
        }

        if ($this->option('no-interaction')) {
            return CssFramework::resolve();
        }

        while (true) {
            $selected = $this->selectFramework();

            switch ($this->promptConfirmation($selected)) {
                case 'confirm':
                    return $selected;
                case 'cancel':
                    $this->info('  Cancelled. No changes were made.');

                    return false;
            }
        }
    }

    /**
     * @return string|false
     */
    protected function validateFramework(string $css)
    {
        if (!CssFramework::isSupported($css)) {
            $this->error("Invalid CSS framework: {$css}. Use: ".implode(', ', CssFramework::supported()));

            return false;
        }

        return $css;
    }

    protected function selectFramework(): string
    {
        $labels = CssFramework::labels();

        if (function_exists('Laravel\Prompts\select')) {
            return \Laravel\Prompts\select(
                label: 'Which CSS framework should the roles GUI use?',
                options: $labels,
                default: CssFramework::resolve(),
            );
        }

        $choice = $this->choice(
            'Which CSS framework should the roles GUI use?',
            array_values($labels),
            $labels[CssFramework::resolve()]
        );

        return (string) array_search($choice, $labels, true);
    }

    protected function promptConfirmation(string $css): string
    {
        $labels = CssFramework::labels();

        $this->newLine();
        $this->line("  \033[1mYour selection:\033[0m");
        $this->line("  \033[90mCSS:\033[0m  ".($labels[$css] ?? $css));
        $this->newLine();

        $options = [
            'confirm' => 'Confirm and continue',
            'restart' => 'Start over',
            'cancel'  => 'Cancel and exit',
        ];

        if (function_exists('Laravel\Prompts\select')) {
            return \Laravel\Prompts\select(
                label: 'Continue with this setting?',
                options: $options,
                default: 'confirm',
            );
        }

        $choice = $this->choice('Continue with this setting?', array_values($options), $options['confirm']);

        return (string) array_search($choice, $options, true);
    }

    protected function showSummary(string $action, string $css): void
    {
        $labels = CssFramework::labels();

        $this->newLine();
        $this->line("  \033[32mLaravel Roles {$action}.\033[0m");
        $this->newLine();
        $this->line("  \033[90mCSS:\033[0m  ".($labels[$css] ?? $css));
        $this->line("  \033[90mViews:\033[0m ".'laravelroles::laravelroles.*');
        $this->newLine();
    }
}
