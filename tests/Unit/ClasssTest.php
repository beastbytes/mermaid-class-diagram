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

defined('ANNOTATION') or define('ANNOTATION', 'Annotation');
defined('ATTRIBUTE_NAME') or define('ATTRIBUTE_NAME', 'attribute');
defined('CLASS_NAMESPACE') or define('CLASS_NAMESPACE', 'Namespace');
defined('COMMENT') or define('COMMENT', 'Class comment');
defined('LABEL') or define('LABEL', 'Label');
defined('METHOD_NAME') or define('METHOD_NAME', 'getAttribute');
defined('NAME') or define('NAME', 'Name');
defined('NOTE') or define('NOTE', 'Note');
defined('STYLE_CLASS') or define('STYLE_CLASS', 'styleClass');

test('Simple class', function () {
    $class = new Classs(name:NAME, namespace: CLASS_NAMESPACE);

    /** @psalm-suppress InternalMethod */
    expect($class->getName())
        ->toBe(NAME)
        ->and($class->getNamespace())
        ->toBe(CLASS_NAMESPACE)
        ->and($class->render(''))
        ->toBe('class ' . NAME . " {\n}")
    ;
});

test('Class with annotation', function () {
    $class = new Classs(
        name: NAME,
        annotation: ANNOTATION
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . NAME . " {\n"
               . '  <<' . ANNOTATION . ">>\n"
               . '}'
        )
    ;
});

test('Class with comment', function () {
    $class = (new Classs(name: NAME))->withComment(COMMENT);

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('%% ' . COMMENT . "\nclass " . NAME . " {\n}")
    ;
});

test('Class with style', function () {
    $class = (new Classs(name: NAME))->withStyleClass(STYLE_CLASS);

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . NAME . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n}")
    ;
});

test('Class with label', function () {
    $class = new Classs(
        name: NAME,
        label: LABEL
    );

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . NAME . '["' . LABEL . '"]' . " {\n}")
    ;
});

test('Class with interaction', function () {
    $class = (new Classs(NAME));
    $output = [];

    $class->withInteraction('https://example.com')->renderInteraction($output);
    expect($output[0])
        ->toBe('  click ' . NAME . ' href "https://example.com" _self')
    ;

    $class->withInteraction('myCallback()')->renderInteraction($output);
    expect($output[1])
        ->toBe('  click ' . NAME . ' call myCallback()')
    ;
});

test('Class with note', function () {
    $output = [];

    (new Classs(NAME))->withNote(NOTE)->renderNote('', $output);
    expect($output[0])
        ->toBe('note for ' . NAME . ' "' . NOTE . '"')
    ;
});

test('Class using addMember', function () {
    $class = (new Classs(name: NAME))
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
        ->toBe('class ' . NAME . " {\n"
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

    $class = (new Classs(name: NAME))
        ->withMember($attribute, $method)
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . NAME . " {\n"
            . '  -string ' . ATTRIBUTE_NAME . "\n"
            . '  +' . METHOD_NAME . "() string\n"
            . '}'
        )
    ;
});

test('Class with everything', function () {
    $class = (new Classs(
        name: NAME,
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
            . 'class ' . NAME . '["' . LABEL . '"]' . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n"
            . '  <<' . ANNOTATION . ">>\n"
            . '  -string ' . ATTRIBUTE_NAME . "\n"
            . '  +' . METHOD_NAME . "() string\n"
            . '}'
        )
    ;
});
