<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Visibility;
use BeastBytes\Mermaid\Mermaid;

const ANNOTATION = 'Annotation';
const ATTRIBUTE_NAME = 'attribute';
const CLASS_NAME = 'TestClass';
const CLASS_NAMESPACE = 'ClassNamespace';
const LABEL = 'Label';
const METHOD_NAME = 'getAttribute';
const NOTE = 'Note';
const STYLE_CLASS = 'styleClass';

test('Simple class', function () {
    $class = new Classs(name:CLASS_NAME, namespace: CLASS_NAMESPACE);

    /** @psalm-suppress InternalMethod */
    expect($class->getName())
        ->toBe(CLASS_NAME)
        ->and($class->getNamespace())
        ->toBe(CLASS_NAMESPACE)
        ->and($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . " {\n  }")
    ;
});

test('Class with annotation', function () {
    $class = new Classs(
        name: CLASS_NAME,
        annotation: ANNOTATION
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . " {\n"
               . '    <<' . ANNOTATION . ">>\n"
               . '  }'
        )
    ;
});

test('Class with style', function () {
    $class = new Classs(name: CLASS_NAME, styleClass: STYLE_CLASS);

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n  }")
    ;
});

test('Class with label', function () {
    $class = new Classs(
        name: CLASS_NAME,
        label: LABEL
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . '["' . LABEL . '"]' . " {\n" . '  }')
    ;
});

test('Class with note', function () {
    $class = new Classs(
        name: CLASS_NAME,
        note: NOTE
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '  note for ' . CLASS_NAME . ' "' . NOTE . '"'
        )
    ;
});

test('Class using addMember', function () {
    $class = (new Classs(name: CLASS_NAME))
        ->addMember(new Attribute(
            name:       ATTRIBUTE_NAME,
            type:       'string',
            visibility: Visibility::Private
        ))
        ->addMember(new Method(
            name:       METHOD_NAME,
            returnType: 'string',
            visibility: Visibility::Public
        ))
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . " {\n"
            . '    -string ' . ATTRIBUTE_NAME . "\n"
            . '    +' . METHOD_NAME . "() string\n"
            . "  }"
        )
    ;
});

test('Class using withMember', function () {
    $attribute = new Attribute(
        name:       ATTRIBUTE_NAME,
        type:       'string',
        visibility: Visibility::Private
    );
    $method = new Method(
        name:       METHOD_NAME,
        returnType: 'string',
        visibility: Visibility::Public
    );

    $class = (new Classs(name: CLASS_NAME))
        ->withMember($attribute, $method)
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . " {\n"
            . '    -string ' . ATTRIBUTE_NAME . "\n"
            . '    +' . METHOD_NAME . "() string\n"
            . "  }"
        )
    ;
});

test('Class with everything', function () {
    $class = (new Classs(
        name: CLASS_NAME,
        annotation: ANNOTATION,
        label: LABEL,
        note: NOTE,
        styleClass: STYLE_CLASS
    ))
        ->withMember(
            new Attribute(
                name: ATTRIBUTE_NAME,
                type: 'string',
                visibility: Visibility::Private
            ),
            new Method(
                name: METHOD_NAME,
                returnType: 'string',
                visibility: Visibility::Public
            )
        )
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(Mermaid::INDENTATION))
        ->toBe('  class ' . CLASS_NAME . '["' . LABEL . '"]' . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n"
            . '    <<' . ANNOTATION . ">>\n"
            . '    -string ' . ATTRIBUTE_NAME . "\n"
            . '    +' . METHOD_NAME . "() string\n"
            . "  }\n"
            . '  note for ' . CLASS_NAME . ' "' . NOTE . '"'
        )
    ;
});
