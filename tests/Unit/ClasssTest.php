<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\InteractionType;
use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Visibility;
use BeastBytes\Mermaid\Mermaid;

const ANNOTATION = 'Annotation';
const ATTRIBUTE_NAME = 'attribute';
const CLASS_NAME = 'TestClass';
const CLASS_NAMESPACE = 'ClassNamespace';
const COMMENT = 'Class comment';
const LABEL = 'Label';
const METHOD_NAME = 'getAttribute';
const NOTE = 'Note';
const STYLE_CLASS = 'styleClass';

test('Simple class', function () {
    $class = new Classs(name:CLASS_NAME, namespace: CLASS_NAMESPACE);

    /** @psalm-suppress InternalMethod */
    expect($class->getId())
        ->toBe(CLASS_NAME)
        ->and($class->getNamespace())
        ->toBe(CLASS_NAMESPACE)
        ->and($class->render(''))
        ->toBe('class ' . CLASS_NAME . " {\n}")
    ;
});

test('Class with annotation', function () {
    $class = new Classs(
        name: CLASS_NAME,
        annotation: ANNOTATION
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . CLASS_NAME . " {\n"
               . '  <<' . ANNOTATION . ">>\n"
               . '}'
        )
    ;
});

test('Class with comment', function () {
    $class = (new Classs(name: CLASS_NAME))->withComment(COMMENT);

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('%% ' . COMMENT . "\nclass " . CLASS_NAME . " {\n}")
    ;
});

test('Class with style', function () {
    $class = (new Classs(name: CLASS_NAME))->withStyleClass(STYLE_CLASS);

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . CLASS_NAME . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n}")
    ;
});

test('Class with label', function () {
    $class = new Classs(
        name: CLASS_NAME,
        label: LABEL
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . CLASS_NAME . '["' . LABEL . '"]' . " {\n}")
    ;
});

test('Class with interaction', function () {
    $class = (new Classs(CLASS_NAME));
    $output = [];

    $class->withInteraction('https://example.com')->renderInteraction($output);
    expect($output[0])
        ->toBe('  click ' . CLASS_NAME . ' href "https://example.com"')
    ;

    $class->withInteraction('myCallback()', InteractionType::Callback)->renderInteraction($output);
    expect($output[1])
        ->toBe('  click ' . CLASS_NAME . ' call myCallback()')
    ;
});

test('Class with note', function () {
    $output = [];

    (new Classs(CLASS_NAME))->withNote(NOTE)->renderNote('', $output);
    expect($output[0])
        ->toBe('note for ' . CLASS_NAME . ' "' . NOTE . '"')
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
    expect($class->render(''))
        ->toBe('class ' . CLASS_NAME . " {\n"
            . '  -string ' . ATTRIBUTE_NAME . "\n"
            . '  +' . METHOD_NAME . "() string\n"
            . '}'
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
    expect($class->render(''))
        ->toBe('class ' . CLASS_NAME . " {\n"
            . '  -string ' . ATTRIBUTE_NAME . "\n"
            . '  +' . METHOD_NAME . "() string\n"
            . '}'
        )
    ;
});

test('Class with everything', function () {
    $class = (new Classs(
        name: CLASS_NAME,
        annotation: ANNOTATION,
        label: LABEL
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
        ->withStyleClass(STYLE_CLASS)
        ->withComment(COMMENT)
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('%% ' . COMMENT . "\n"
            . 'class ' . CLASS_NAME . '["' . LABEL . '"]' . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n"
            . '  <<' . ANNOTATION . ">>\n"
            . '  -string ' . ATTRIBUTE_NAME . "\n"
            . '  +' . METHOD_NAME . "() string\n"
            . '}'
        )
    ;
});
