<?php

use MagicDocs\Parsers\ProxyMethod;

test('parser proxy method can create docs', function () {
    $parser = new ProxyMethod();
    $parser->withConfig([
        'proxy' => [
            '__construct' => 'spawn',
        ],
    ]);

    $doc = $parser->parse(getFile('ClassWithProxyMethod'));

    expect((string) $doc)->toBe(
        '@method static \MagicDocs\ClassWithProxyMethod spawn(string $foo, int $bar, bool $baz = false)'
    );
});

test('parser proxy method can create docs with variadic argument', function () {
    $parser = new ProxyMethod();
    $parser->withConfig([
        'proxy' => [
            '__construct2' => 'spawn2',
        ],
    ]);

    $doc = $parser->parse(getFile('ClassWithProxyMethod'));

    expect((string) $doc)->toBe(
        '@method static \MagicDocs\ClassWithProxyMethod spawn2(...$items)'
    );
});

test('parser proxy method can create docs with variadic argument and excluded argument', function () {
    $parser = new ProxyMethod();
    $parser->withConfig([
        'proxy' => [
            '__construct3' => [
                'to' => 'spawn3',
                'exclude' => ['spawnIf'],
            ],
        ],
    ]);

    $doc = $parser->parse(getFile('ClassWithProxyMethod'));

    expect((string) $doc)->toBe(
        '@method \MagicDocs\ClassWithProxyMethod|null spawn3(...$items)'
    );
});