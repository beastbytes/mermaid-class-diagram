<?php

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\Visibility;

defined('NAME') or define('NAME', 'Name');

test('Simple attribute', function () {
    expect((new Attribute(NAME))->render(''))
        ->toBe(NAME)
    ;
});

test('Attribute with visibility', function (Visibility $visibility) {
    expect((new Attribute(NAME, visibility: $visibility))->render(''))
        ->toBe($visibility->value . 'Name')
    ;
})
    ->with('visibility')
;

test('Attribute with type', function () {
    expect((new Attribute(NAME, 'string'))->render(''))
        ->toBe('string Name')
    ;
});

test('Static attribute', function () {
    expect((new Attribute(NAME, 'string', isStatic: Attribute::IS_STATIC))->render(''))
        ->toBe('string Name$')
    ;
});

test('Attribute with everything', function () {
    expect((new Attribute(NAME, 'string', Visibility::public, Attribute::IS_STATIC))
        ->render('')
    )
        ->toBe('+string Name$')
    ;
});

dataset('visibility', [
    Visibility::public,
    Visibility::protected,
    Visibility::private,
    Visibility::internal
]);