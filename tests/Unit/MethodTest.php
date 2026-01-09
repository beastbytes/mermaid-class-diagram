<?php

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Classifier;
use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Visibility;

defined('NAME') or define('NAME', 'Name');

test('Simple method', function () {
    expect((new Method(NAME))->render(''))
        ->toBe('Name()')
    ;
});

test('Method with visibility', function (Visibility $visibility) {
    expect((new Method(
        name: NAME,
        visibility: $visibility
    ))
        ->render('')
    )
        ->toBe($visibility->value . 'Name()')
    ;
})
    ->with([
        Visibility::public,
        Visibility::protected,
        Visibility::private,
        Visibility::internal
   ])
;

test('Method with parameters', function () {
    expect((new Method(
        name: NAME,
        parameters: ['string' => '$string', 'bool' => '$bool', 'int' => '$int']
    ))
        ->render('')
    )
        ->toBe('Name(string $string, bool $bool, int $int)')
    ;
});

test('Method with return type', function () {
    expect((new Method(
        name: NAME,
        returnType: 'string'
    ))
        ->render('')
    )
        ->toBe('Name() string')
    ;
});

test('Method with classifier', function () {
    expect((new Method(name: NAME, isAbstract: Method::IS_ABSTRACT))->render(''))
        ->toBe('Name()*')
    ;
    expect((new Method(name: NAME, isStatic: Method::IS_STATIC))->render(''))
        ->toBe('Name()$')
    ;
    expect((new Method(name: NAME, isAbstract: Method::IS_ABSTRACT, isStatic: Method::IS_STATIC))->render(''))
        ->toBe('Name()*$')
    ;
});

test('Method with everything', function () {
    expect((new Method(
        name: NAME,
        parameters: ['string' => '$string', 'bool' => '$bool', 'int' => '$int'],
        returnType: 'string',
        visibility: Visibility::public,
        isStatic: Method::IS_STATIC
    ))
        ->render('')
    )
        ->toBe('+Name(string $string, bool $bool, int $int) string$')
    ;
});