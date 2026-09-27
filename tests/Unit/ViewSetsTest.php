<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Support\CssFramework;

/**
 * @return array<int, string>
 */
function viewFiles(string $framework): array
{
    $root = CssFramework::viewPath($framework);
    $files = [];

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));

    foreach ($iterator as $file) {
        $files[] = str_replace($root.DIRECTORY_SEPARATOR, '', $file->getPathname());
    }

    sort($files);

    return $files;
}

it('keeps every framework at exactly the same set of views', function (): void {
    $baseline = viewFiles(CssFramework::BOOTSTRAP4);

    expect($baseline)->not->toBeEmpty();

    foreach ([CssFramework::BOOTSTRAP5, CssFramework::TAILWIND] as $framework) {
        expect(viewFiles($framework))->toEqual(
            $baseline,
            "{$framework} does not ship the same views as bootstrap4"
        );
    }
});

it('keeps bootstrap classes out of the tailwind views', function (): void {
    $bootstrapOnly = [
        'col-sm-', 'col-md-', 'col-lg-', 'container-fluid',
        'card-header', 'card-body', 'form-control', 'form-group',
        'list-group-item', 'data-toggle=', 'data-bs-toggle=',
        'btn-outline-', 'badge-pill', 'rounded-pill',
    ];

    $offenders = [];

    foreach (viewFiles(CssFramework::TAILWIND) as $file) {
        $contents = file_get_contents(CssFramework::viewPath(CssFramework::TAILWIND).'/'.$file);

        foreach ($bootstrapOnly as $token) {
            if (str_contains($contents, $token)) {
                $offenders[] = "{$file} contains {$token}";
            }
        }
    }

    expect($offenders)->toBeEmpty();
});

it('keeps tailwind utilities out of the bootstrap views', function (string $framework): void {
    $tailwindOnly = ['dark:', 'x-data=', 'focus-visible:ring', 'text-gray-', 'bg-gray-'];

    $offenders = [];

    foreach (viewFiles($framework) as $file) {
        $contents = file_get_contents(CssFramework::viewPath($framework).'/'.$file);

        foreach ($tailwindOnly as $token) {
            if (str_contains($contents, $token)) {
                $offenders[] = "{$file} contains {$token}";
            }
        }
    }

    expect($offenders)->toBeEmpty();
})->with(['bootstrap4', 'bootstrap5']);

it('leaves the bootstrap4 views on bootstrap 4 attributes', function (): void {
    $dashboard = file_get_contents(CssFramework::viewPath(CssFramework::BOOTSTRAP4).'/laravelroles/cards/roles-card.blade.php');

    expect($dashboard)->toContain('data-toggle="collapse"')
        ->and($dashboard)->not->toContain('data-bs-toggle=');
});

it('moves the bootstrap5 views onto bootstrap 5 attributes', function (): void {
    $card = file_get_contents(CssFramework::viewPath(CssFramework::BOOTSTRAP5).'/laravelroles/cards/roles-card.blade.php');

    expect($card)->toContain('data-bs-toggle="collapse"')
        ->and($card)->not->toContain('data-toggle="collapse"');
});

it('marks every tailwind x-show element with x-cloak', function (): void {
    $offenders = [];

    foreach (viewFiles(CssFramework::TAILWIND) as $file) {
        $contents = file_get_contents(CssFramework::viewPath(CssFramework::TAILWIND).'/'.$file);
        $shows = substr_count($contents, 'x-show');

        if ($shows > 0 && substr_count($contents, 'x-cloak') < $shows) {
            $offenders[] = $file;
        }
    }

    expect($offenders)->toBeEmpty();
});

it('ships the x-cloak rule the tailwind views rely on', function (): void {
    $styles = file_get_contents(CssFramework::viewPath(CssFramework::TAILWIND).'/laravelroles/partials/styles.blade.php');

    expect($styles)->toContain('[x-cloak]')
        ->and($styles)->toContain('display: none !important');
});

it('gives every tailwind alpine directive an x-data root in the same file', function (): void {
    $offenders = [];

    foreach (viewFiles(CssFramework::TAILWIND) as $file) {
        $contents = file_get_contents(CssFramework::viewPath(CssFramework::TAILWIND).'/'.$file);

        $usesDirectives = str_contains($contents, 'x-on:')
            || str_contains($contents, 'x-show')
            || str_contains($contents, 'x-text');

        if ($usesDirectives && !str_contains($contents, 'x-data')) {
            $offenders[] = $file;
        }
    }

    expect($offenders)->toBeEmpty();
});

it('keeps framework specific markup out of the shared translation strings', function (string $locale): void {
    $strings = require dirname(__DIR__, 2)."/src/resources/lang/{$locale}/laravelroles.php";

    $offenders = [];

    // Plain emphasis is fine. CSS classes and icon tags are not: the strings
    // are shared by all three view sets, which each draw their own icons.
    array_walk_recursive($strings, function ($value, $key) use (&$offenders) {
        if (is_string($value) && preg_match('/class=|<i[\s>]|<svg/i', $value)) {
            $offenders[] = $key;
        }
    });

    expect($offenders)->toBeEmpty();
})->with(['en', 'de', 'fr']);

it('gives the row actions an icon drawn from the active framework', function (string $framework, string $needle): void {
    foreach (['role', 'permission'] as $type) {
        $table = file_get_contents(CssFramework::viewPath($framework)."/laravelroles/tables/{$type}-items-table.blade.php");

        expect($table)->toContain($needle);
    }
})->with([
    ['bootstrap4', 'fa fa-eye'],
    ['bootstrap5', 'fa-solid fa-eye'],
    ['tailwind', '<svg'],
]);

it('keeps the source within the php version composer declares', function (): void {
    // composer.json still allows ^7.2, but the test matrix only runs 8.2 and
    // above, so nothing else would catch syntax that needs a later runtime.
    $patterns = [
        'typed property (7.4+)'        => '/^\s*(?:public|protected|private)\s+(?:static\s+)?(?!static\b)\??[A-Za-z_\\\\|]+\s+\$[a-zA-Z_]/m',
        'arrow function (7.4+)'        => '/\bfn\s*\(/',
        'null-safe operator (8.0+)'    => '/\?->/',
        'match expression (8.0+)'      => '/\bmatch\s*\(/',
        'constructor promotion (8.0+)' => '/function\s+__construct\s*\([^)]*\b(?:public|protected|private)\s+\$/',
    ];

    $offenders = [];

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../../src')) as $file) {
        if ($file->getExtension() !== 'php' || str_contains($file->getPathname(), '.blade.')) {
            continue;
        }

        $code = file_get_contents($file->getPathname());

        foreach ($patterns as $label => $pattern) {
            if (preg_match($pattern, $code)) {
                $offenders[] = basename($file->getPathname()).': '.$label;
            }
        }
    }

    expect($offenders)->toBeEmpty();
});
