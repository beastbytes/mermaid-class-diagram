<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Visibility;
use BeastBytes\Mermaid\Mermaid;

const NAME = 'TestMethod';

test('Simple method', function () {
    $method = new Method(NAME);

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . NAME . '()')
    ;
});

test('Method with visibility', function (Visibility $visibility) {
    $method = new Method(
        name:       NAME,
        visibility: $visibility
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . $visibility->value . NAME . '()')
    ;
})
    ->with([
        Visibility::Public,
        Visibility::Protected,
        Visibility::Private,
        Visibility::Internal
   ])
;

test('Method with parameters', function () {
    $method = new Method(
        name:       NAME,
        parameters: ['string $string', 'bool $bool', 'int $int']
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . NAME . '(string $string, bool $bool, int $int)')
    ;
});

test('Method with return type', function () {
    $method = new Method(
        name:       NAME,
        returnType: 'string'
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . NAME . '() string')
    ;
});

test('Method with everything', function () {
    $method = new Method(
        name:       NAME,
        parameters: ['string $string', 'bool $bool', 'int $int'],
        returnType: 'string',
        visibility: Visibility::Public
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . Visibility::Public->value . NAME . '(string $string, bool $bool, int $int) string')
    ;
});
