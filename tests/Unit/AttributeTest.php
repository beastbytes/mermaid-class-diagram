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

test('Method with type', function () {
    expect((new Attribute(NAME, 'string'))->render(''))
        ->toBe('string ' . 'Name')
    ;
});

test('Attribute with everything', function () {
    expect((new Attribute(NAME, 'string', Visibility::public))->render(''))
        ->toBe(Visibility::public->value . 'string ' . 'Name')
    ;
});

dataset('visibility', [
    Visibility::public,
    Visibility::protected,
    Visibility::private,
    Visibility::internal
]);