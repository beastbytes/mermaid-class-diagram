<?php

declare(strict_types=1);

use BeastBytes\Mermaid\InteractionType;
use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Visibility;

defined('ANNOTATION') or define('ANNOTATION', 'Annotation');
defined('ATTRIBUTE1') or define('ATTRIBUTE1', 'attribute1');
defined('ATTRIBUTE2') or define('ATTRIBUTE2', 'attribute2');
defined('CLASS_NAMESPACE') or define('CLASS_NAMESPACE', 'Namespace');
defined('COMMENT') or define('COMMENT', 'Class comment');
defined('GETTER1') or define('GETTER1', 'getAttribute1');
defined('GETTER2') or define('GETTER2', 'getAttribute2');
defined('LABEL') or define('LABEL', 'Label');
defined('NAME') or define('NAME', 'Name');
defined('NOTE') or define('NOTE', 'Note');
defined('SETTER1') or define('SETTER1', 'setAttribute1');
defined('SETTER2') or define('SETTER2', 'setAttribute2');
defined('STYLE_CLASS') or define('STYLE_CLASS', 'styleClass');

test('Simple class', function () {
    $class = new Classs(name:NAME, namespace: CLASS_NAMESPACE);

    /** @psalm-suppress InternalMethod */
    expect($class->getId())
        ->toBe(NAME)
        ->and($class->getNamespace())
        ->toBe(CLASS_NAMESPACE)
        ->and($class->render(''))
        ->toBe("class Name {\n}")
    ;
});

test('Class with annotation', function () {
    /** @psalm-suppress InternalMethod */
    expect((new Classs(name: NAME, annotation: ANNOTATION))->render(''))
        ->toBe(<<<EXPECTED
class Name {
  <<Annotation>>
}
EXPECTED
        )
    ;
});

test('Class with comment', function () {
    /** @psalm-suppress InternalMethod */
    expect((new Classs(name: NAME))->withComment(COMMENT)->render(''))
        ->toBe(<<<EXPECTED
%% Class comment
class Name {
}
EXPECTED
        )
    ;
});

test('Class with style', function () {
    /** @psalm-suppress InternalMethod */
    expect((new Classs(name: NAME))->withStyleClass(STYLE_CLASS)->render(''))
        ->toBe(<<<EXPECTED
class Name:::styleClass {
}
EXPECTED
        )
    ;
});

test('Class with label', function () {
    /** @psalm-suppress InternalMethod */
    expect((new Classs(name: NAME, label: LABEL))->render(''))
        ->toBe(<<<EXPECTED
class Name["Label"] {
}
EXPECTED
        )
    ;
});

test('Class with interaction', function () {
    $class = new Classs(NAME);

    expect($class->withInteraction('https://example.com', InteractionType::link)->renderInteraction())
        ->toBe('  click Name href "https://example.com" _self')
        ->and($class->withInteraction('myCallback()', InteractionType::callback)->renderInteraction())
        ->toBe('  click Name call myCallback()')
    ;
});

test('Class with note', function () {
    $class = new Classs(NAME);

    expect($class->withNote(NOTE)->renderNote(''))
        ->toBe('note for Name "Note"')
    ;
});

test('Attribute and method sorting', function () {
    expect(
        (new Classs(name: NAME))
            ->withAttribute(
                new Attribute(
                    'attribute06',
                    'string',
                    Visibility::internal
                ),
                new Attribute(
                    'attribute07',
                    'string',
                    Visibility::private
                ),
                new Attribute(
                    'attribute08',
                    'string',
                    Visibility::protected
                ),
                new Attribute(
                    'attribute09',
                    'string',
                    Visibility::public
                ),
                new Attribute(
                    'attribute10',
                    'string'
                ),
                new Attribute(
                    'attribute16',
                    'string',
                    Visibility::internal,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute17',
                    'string',
                    Visibility::private,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute18',
                    'string',
                    Visibility::protected,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute19',
                    'string',
                    Visibility::public,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute20',
                    'string',
                    isStatic: Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute01',
                    'string',
                    Visibility::internal
                ),
                new Attribute(
                    'attribute02',
                    'string',
                    Visibility::private
                ),
                new Attribute(
                    'attribute03',
                    'string',
                    Visibility::protected
                ),
                new Attribute(
                    'attribute04',
                    'string',
                    Visibility::public
                ),
                new Attribute(
                    'attribute05',
                    'string'
                ),
                new Attribute(
                    'attribute11',
                    'string',
                    Visibility::internal,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute12',
                    'string',
                    Visibility::private,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute13',
                    'string',
                    Visibility::protected,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute14',
                    'string',
                    Visibility::public,
                    Attribute::IS_STATIC
                ),
                new Attribute(
                    'attribute15',
                    'string',
                    isStatic: Attribute::IS_STATIC
                ),
            )
            ->withMethod(
                new Method(
                    'method06',
                    returnType: 'string',
                    visibility: Visibility::internal
                ),
                new Method(
                    'method07',
                    returnType: 'string',
                    visibility: Visibility::private
                ),
                new Method(
                    'method08',
                    returnType: 'string',
                    visibility: Visibility::protected
                ),
                new Method(
                    'method09',
                    returnType: 'string',
                    visibility: Visibility::public
                ),
                new Method(
                    'method10',
                    returnType: 'string'
                ),
                new Method(
                    'method16',
                    returnType: 'string',
                    visibility: Visibility::internal,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method17',
                    returnType: 'string',
                    visibility: Visibility::private,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method18',
                    returnType: 'string',
                    visibility: Visibility::protected,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method19',
                    returnType: 'string',
                    visibility: Visibility::public,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method20',
                    returnType: 'string',
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method01',
                    returnType: 'string',
                    visibility: Visibility::internal
                ),
                new Method(
                    'method02',
                    returnType: 'string',
                    visibility: Visibility::private
                ),
                new Method(
                    'method03',
                    returnType: 'string',
                    visibility: Visibility::protected
                ),
                new Method(
                    'method04',
                    returnType: 'string',
                    visibility: Visibility::public
                ),
                new Method(
                    'method05',
                    returnType: 'string',
                ),
                new Method(
                    'method11',
                    returnType: 'string',
                    visibility: Visibility::internal,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method12',
                    returnType: 'string',
                    visibility: Visibility::private,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method13',
                    returnType: 'string',
                    visibility: Visibility::protected,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method14',
                    returnType: 'string',
                    visibility: Visibility::public,
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method15',
                    returnType: 'string',
                    isAbstract: Method::IS_ABSTRACT
                ),
                new Method(
                    'method31',
                    returnType: 'string',
                    visibility: Visibility::internal,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method32',
                    returnType: 'string',
                    visibility: Visibility::private,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method33',
                    returnType: 'string',
                    visibility: Visibility::protected,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method34',
                    returnType: 'string',
                    visibility: Visibility::public,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method35',
                    returnType: 'string',
                    isAbstract:Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method36',
                    returnType: 'string',
                    visibility: Visibility::internal,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method37',
                    returnType: 'string',
                    visibility: Visibility::private,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method38',
                    returnType: 'string',
                    visibility: Visibility::protected,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method39',
                    returnType: 'string',
                    visibility: Visibility::public,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method40',
                    returnType: 'string',
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method26',
                    returnType: 'string',
                    visibility: Visibility::internal,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method27',
                    returnType: 'string',
                    visibility: Visibility::private,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method28',
                    returnType: 'string',
                    visibility: Visibility::protected,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method29',
                    returnType: 'string',
                    visibility: Visibility::public,
                    isAbstract: Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method30',
                    returnType: 'string',
                    isAbstract:Method::IS_ABSTRACT,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method21',
                    returnType: 'string',
                    visibility: Visibility::internal,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method22',
                    returnType: 'string',
                    visibility: Visibility::private,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method23',
                    returnType: 'string',
                    visibility: Visibility::protected,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method24',
                    returnType: 'string',
                    visibility: Visibility::public,
                    isStatic: Method::IS_STATIC
                ),
                new Method(
                    'method25',
                    returnType: 'string',
                    isStatic: Method::IS_STATIC
                ),
            )
            ->render('')
    )
        ->toBe(<<<'EXPECTED'
class Name {
  +string attribute14$
  string attribute15$
  +string attribute19$
  string attribute20$
  +string attribute04
  string attribute05
  +string attribute09
  string attribute10
  #string attribute13$
  #string attribute18$
  #string attribute03
  #string attribute08
  -string attribute12$
  -string attribute17$
  -string attribute02
  -string attribute07
  ~string attribute11$
  ~string attribute16$
  ~string attribute01
  ~string attribute06
  +method29() string*$
  method30() string*$
  +method34() string*$
  method35() string*$
  +method14() string*
  method15() string*
  +method19() string*
  method20() string*
  +method24() string$
  method25() string$
  +method39() string$
  method40() string$
  +method04() string
  method05() string
  +method09() string
  method10() string
  #method28() string*$
  #method33() string*$
  #method13() string*
  #method18() string*
  #method23() string$
  #method38() string$
  #method03() string
  #method08() string
  -method27() string*$
  -method32() string*$
  -method12() string*
  -method17() string*
  -method22() string$
  -method37() string$
  -method02() string
  -method07() string
  ~method26() string*$
  ~method31() string*$
  ~method11() string*
  ~method16() string*
  ~method21() string$
  ~method36() string$
  ~method01() string
  ~method06() string
}
EXPECTED
        )
    ;
});

test('Class using withAttribute and withMethod', function () {
    /** @psalm-suppress InternalMethod */
    expect(
        (new Classs(name: NAME))
            ->withAttribute(new Attribute(ATTRIBUTE1, 'string', Visibility::private))
            ->addAttribute(new Attribute( ATTRIBUTE2, 'bool', Visibility::private))
            ->withMethod(
                new Method(
                    name: GETTER1,
                    returnType: 'string',
                    visibility: Visibility::public
                ),
                new Method(
                    name: SETTER1,
                    parameters: ['string' => '$value'],
                    returnType: 'Name',
                    visibility: Visibility::public
                )
            )
            ->addMethod(
                new Method(
                    name: GETTER2,
                    returnType: 'bool',
                    visibility: Visibility::public
                ),
                new Method(
                    name: SETTER2,
                    parameters: ['bool' => '$value'],
                    returnType: 'Name',
                    visibility: Visibility::public
                )
            )
            ->render('')
    )
        ->toBe(<<<'EXPECTED'
class Name {
  -string attribute1
  -bool attribute2
  +getAttribute1() string
  +getAttribute2() bool
  +setAttribute1(string $value) Name
  +setAttribute2(bool $value) Name
}
EXPECTED
        )
    ;
});

test('Class with everything', function () {
    /** @psalm-suppress InternalMethod */
    expect(
        (new Classs(
            name: NAME,
            annotation: ANNOTATION,
            label: LABEL
        ))
            ->withAttribute(new Attribute(ATTRIBUTE1, 'string', Visibility::private))
            ->addAttribute(new Attribute(ATTRIBUTE2, 'bool', Visibility::private))
            ->withMethod(
                new Method(
                    name: GETTER1,
                    returnType: 'string',
                    visibility: Visibility::public
                ),
                new Method(
                    name: SETTER1,
                    parameters: ['string' => '$value'],
                    returnType: 'Name',
                    visibility: Visibility::public
                )
            )
            ->addMethod(
                new Method(
                    name: GETTER2,
                    returnType: 'bool',
                    visibility: Visibility::public
                ),
                new Method(
                    name: SETTER2,
                    parameters: ['bool' => '$value'],
                    returnType: 'Name',
                    visibility: Visibility::public
                )
            )
            ->withStyleClass(STYLE_CLASS)
            ->withComment(COMMENT)
            ->render('')
    )
        ->toBe(<<<'EXPECT'
%% Class comment
class Name["Label"]:::styleClass {
  <<Annotation>>
  -string attribute1
  -bool attribute2
  +getAttribute1() string
  +getAttribute2() bool
  +setAttribute1(string $value) Name
  +setAttribute2(bool $value) Name
}
EXPECT
        )
    ;
});