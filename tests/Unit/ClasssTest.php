<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\VisibilityEnum;
use BeastBytes\Mermaid\Mermaid;

const ANNOTATION = 'Annotation';
const ATTRIBUTE_NAME = 'attribute';
const LABEL = 'Label';
const METHOD_NAME = 'getAttribute';
const NAME = 'TestClass';
const NOTE = 'Note';

test('Simple class', function () {
    $class = new Classs(NAME);

    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . NAME . " {\n"
            . '  }'
        )
    ;
});

test('Class with annotation', function () {
    $class = new Classs(
        name: NAME,
       annotation: ANNOTATION
    );

    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . NAME . " {\n"
            . '    &lt;&lt;' . ANNOTATION . "&gt;&gt;\n"
            . '  }'
        )
    ;
});

test('Class with label', function () {
    $class = new Classs(
        name: NAME,
        label: LABEL
    );

    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . NAME . '["' . LABEL . '"]' . " {\n"
            . '  }'
        )
    ;
});

test('Class with note', function () {
    $class = new Classs(
        name: NAME,
        note: NOTE
    );

    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . NAME . " {\n"
            . "  }\n"
            . '  note for ' . NAME . ' "' . NOTE . '"'
        )
    ;
});

test('Class with members', function () {
    $class = new Classs(
        name: NAME
    );

    $class
        ->member(new Attribute(
            name: ATTRIBUTE_NAME,
            type: 'string',
            visibility: VisibilityEnum::Private
        ))
        ->member(new Method(
            name: METHOD_NAME,
            returnType: 'string',
            visibility: VisibilityEnum::Public
        ))
    ;

    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . NAME . " {\n"
            . '    -string ' . ATTRIBUTE_NAME . "\n"
            . '    +' . METHOD_NAME . "() string\n"
            . "  }"
        )
    ;
});

test('Class with everything', function () {
    $class = new Classs(
        name: NAME,
        annotation: ANNOTATION,
        label: LABEL,
        note: NOTE
    );

    $class
        ->member(new Attribute(
            name: ATTRIBUTE_NAME,
            type: 'string',
            visibility: VisibilityEnum::Private
        ))
        ->member(new Method(
            name: METHOD_NAME,
            returnType: 'string',
            visibility: VisibilityEnum::Public
        ))
    ;

    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . NAME . '["' . LABEL . '"]' . " {\n"
            . '    &lt;&lt;' . ANNOTATION . "&gt;&gt;\n"
            . '    -string ' . ATTRIBUTE_NAME . "\n"
            . '    +' . METHOD_NAME . "() string\n"
            . "  }\n"
            . '  note for ' . NAME . ' "' . NOTE . '"'
        )
    ;
});
