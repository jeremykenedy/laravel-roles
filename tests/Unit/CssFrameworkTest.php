<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Support\CssFramework;

it('ships a view directory for every supported framework', function (): void {
    foreach (CssFramework::supported() as $framework) {
        expect(is_dir(CssFramework::viewPath($framework)))->toBeTrue(
            "Missing view directory for {$framework}"
        );
    }
});

it('defaults to bootstrap4 so upgrading does not restyle an existing install', function (): void {
    expect(CssFramework::resolve())->toBe(CssFramework::BOOTSTRAP4);
});

it('resolves the configured framework', function (string $framework): void {
    config(['roles.cssFramework' => $framework]);

    expect(CssFramework::resolve())->toBe($framework);
})->with(['bootstrap4', 'bootstrap5', 'tailwind']);

it('falls back to bootstrap4 rather than leaving the gui without views', function ($value): void {
    config(['roles.cssFramework' => $value]);

    expect(CssFramework::resolve())->toBe(CssFramework::BOOTSTRAP4);
})->with([
    'unknown framework' => 'bulma',
    'empty string'      => '',
    'null'              => null,
    'non string'        => 5,
]);

it('ignores the ui kit framework unless the integration is enabled', function (): void {
    config([
        'roles.cssFramework'   => 'bootstrap4',
        'roles.uiKit.enabled'  => false,
        'ui-kit.css_framework' => 'tailwind',
    ]);

    expect(CssFramework::resolve())->toBe(CssFramework::BOOTSTRAP4);
});

it('follows the ui kit framework when the integration is enabled', function (): void {
    config([
        'roles.cssFramework'   => 'bootstrap4',
        'roles.uiKit.enabled'  => true,
        'ui-kit.css_framework' => 'tailwind',
    ]);

    expect(CssFramework::resolve())->toBe(CssFramework::TAILWIND);
});

it('keeps its own framework when ui kit reports one it cannot render', function (): void {
    config([
        'roles.cssFramework'   => 'bootstrap5',
        'roles.uiKit.enabled'  => true,
        'ui-kit.css_framework' => 'bulma',
    ]);

    expect(CssFramework::resolve())->toBe(CssFramework::BOOTSTRAP5);
});

it('reports support only for the frameworks it ships', function (): void {
    expect(CssFramework::isSupported('tailwind'))->toBeTrue()
        ->and(CssFramework::isSupported('bootstrap3'))->toBeFalse()
        ->and(CssFramework::isSupported(null))->toBeFalse();
});

it('labels every supported framework', function (): void {
    expect(array_keys(CssFramework::labels()))
        ->toEqualCanonicalizing(CssFramework::supported());
});

it('defaults the font awesome cdn to the icon set the framework uses', function (string $framework, string $expected): void {
    putenv("ROLES_CSS_FRAMEWORK={$framework}");

    try {
        $config = require __DIR__.'/../../src/config/roles.php';
    } finally {
        putenv('ROLES_CSS_FRAMEWORK');
    }

    expect($config['cssFramework'])->toBe($framework)
        ->and($config['fontAwesomeCDN'])->toContain($expected);
})->with([
    'bootstrap4 keeps Font Awesome 4' => ['bootstrap4', 'font-awesome/4.7.0'],
    'bootstrap5 moves to Font Awesome 6' => ['bootstrap5', 'fontawesome-free@6.7.2'],
    'tailwind loads neither, so the default is unused' => ['tailwind', 'fontawesome-free@6.7.2'],
]);
