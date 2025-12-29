<?php

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
    $class = new Classs(name: NAME, annotation: ANNOTATION);

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . NAME . " {\n"
               . '  <<' . ANNOTATION . ">>\n"
               . '}'
        )
    ;
});

test('Class with comment', function () {
    $class = new Classs(name: NAME);

    /** @psalm-suppress InternalMethod */
    expect($class->withComment(COMMENT)->render(''))
        ->toBe('%% ' . COMMENT . "\nclass " . NAME . " {\n}")
    ;
});

test('Class with style', function () {
    $class = new Classs(name: NAME);

    /** @psalm-suppress InternalMethod */
    expect($class->withStyleClass(STYLE_CLASS)->render(''))
        ->toBe('class ' . NAME . Mermaid::CLASS_OPERATOR . STYLE_CLASS . " {\n}")
    ;
});

test('Class with label', function () {
    $class = new Classs(name: NAME, label: LABEL);

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe('class ' . NAME . '["' . LABEL . '"]' . " {\n}")
    ;
});

test('Class with interaction', function () {
    $class = new Classs(NAME);

    expect($class->withInteraction('https://example.com', InteractionType::Link)->renderInteraction())
        ->toBe('  click ' . NAME . ' href "https://example.com" _self')
        ->and($class->withInteraction('myCallback()', InteractionType::Callback)->renderInteraction())
        ->toBe('  click ' . NAME . ' call myCallback()')
    ;
});

test('Class with note', function () {
    $class = new Classs(NAME);

    expect($class->withNote(NOTE)->renderNote(''))
        ->toBe('note for ' . NAME . ' "' . NOTE . '"')
    ;
});

test('Class using addMember', function () {
    $class = (new Classs(name: NAME))
        ->addMember(new Attribute(
            name:       ATTRIBUTE_NAME,
            type:       'string',
            visibility: Visibility::private
        ))
        ->addMember(new Method(
            name:       METHOD_NAME,
            returnType: 'string',
            visibility: Visibility::public
        ))
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe(<<<EXPECTED
class Name {
  -string attribute
  +getAttribute() string
}
EXPECTED
        )
    ;
});

test('Class using withMember', function () {
    $attribute = new Attribute(
        name: ATTRIBUTE_NAME,
        type: 'string',
        visibility: Visibility::private
    );
    $method = new Method(
        name: METHOD_NAME,
        returnType: 'string',
        visibility: Visibility::public
    );

    $class = (new Classs(name: NAME))
        ->withMember($attribute, $method)
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe(<<<EXPECTED
class Name {
  -string attribute
  +getAttribute() string
}
EXPECTED
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
                visibility: Visibility::private
            ),
            new Method(
                name: METHOD_NAME,
                returnType: 'string',
                visibility: Visibility::public
            )
        )
        ->withStyleClass(STYLE_CLASS)
        ->withComment(COMMENT)
    ;

    /** @psalm-suppress InternalMethod */
    expect($class->render(''))
        ->toBe(<<<EXPECT
%% Class comment
class Name["Label"]:::styleClass {
  <<Annotation>>
  -string attribute
  +getAttribute() string
}
EXPECT
        )
    ;
});