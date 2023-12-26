<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\Visibility;
use BeastBytes\Mermaid\Mermaid;

const NAME = 'TestAttribute';

test('Simple attribute', function () {
    $attribute = new Attribute(NAME);

    expect($attribute->render(Mermaid::INDENTATION))
        ->toBe('  ' . NAME)
    ;
});

test('Attribute with visibility', function (Visibility $visibility) {
    $method = new Attribute(
        name:NAME,
        visibility: $visibility
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . $visibility->value . NAME)
    ;
})
    ->with([
        Visibility::Public,
        Visibility::Protected,
        Visibility::Private,
        Visibility::Internal
   ])
;

test('Method with type', function () {
    $method = new Attribute(
        name:NAME,
        type: 'string'
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  string ' . NAME)
    ;
});

test('Attribute with everything', function () {
    $method = new Attribute(
        name:NAME,
        type: 'string',
        visibility: Visibility::Public
    );

    expect($method->render(Mermaid::INDENTATION))
        ->toBe('  ' . Visibility::Public->value . 'string ' . NAME)
    ;
});
