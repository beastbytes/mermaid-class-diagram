<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Visibility;

defined('NAME') or define('NAME', 'Name');

test('Simple method', function () {
    $method = new Method(NAME);

    expect($method->render(''))
        ->toBe(NAME . '()')
    ;
});

test('Method with visibility', function (Visibility $visibility) {
    $method = new Method(
        name:       NAME,
        visibility: $visibility
    );

    expect($method->render(''))
        ->toBe($visibility->value . NAME . '()')
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

    expect($method->render(''))
        ->toBe(NAME . '(string $string, bool $bool, int $int)')
    ;
});

test('Method with return type', function () {
    $method = new Method(
        name:       NAME,
        returnType: 'string'
    );

    expect($method->render(''))
        ->toBe(NAME . '() string')
    ;
});

test('Method with everything', function () {
    $method = new Method(
        name:       NAME,
        parameters: ['string $string', 'bool $bool', 'int $int'],
        returnType: 'string',
        visibility: Visibility::Public
    );

    expect($method->render(''))
        ->toBe(Visibility::Public->value . NAME . '(string $string, bool $bool, int $int) string')
    ;
});
