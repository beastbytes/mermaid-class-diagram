<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Attribute;
use BeastBytes\Mermaid\ClassDiagram\ClassDiagram;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Method;
use BeastBytes\Mermaid\ClassDiagram\Relationship;
use BeastBytes\Mermaid\ClassDiagram\RelationshipType;
use BeastBytes\Mermaid\ClassDiagram\Visibility;
use BeastBytes\Mermaid\Mermaid;

const CLASS_NAME = 'TestClass';
const CSS_CLASS = 'css-class';
const NAMESPACED = 'Namespaced';
const TITLE = 'Title';
const NOTE = 'Note';

test('Simple classDiagram', function () {
    $diagram = new ClassDiagram();
    $class = new Classs(CLASS_NAME);

    $diagram->class($class);

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with namespaced class', function () {
    $diagram = new ClassDiagram();
    $class = new Classs(CLASS_NAME);

    $diagram->class($class, NAMESPACED);

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  namespace ' . NAMESPACED . " {\n"
            . '    class ' . CLASS_NAME . " {\n"
            . "    }\n"
           . "  }\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with note', function () {
    $diagram = new ClassDiagram(note: NOTE);
    $class = new Classs(CLASS_NAME);

    $diagram->class($class);

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '  note "' . NOTE . "\"\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with title', function () {
    $diagram = new ClassDiagram(title: TITLE);
    $class = new Classs(CLASS_NAME);

    $diagram->class($class);

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . TITLE . "\n"
            . "---\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with style', function () {
    $diagram = new ClassDiagram();
    $class = new Classs(CLASS_NAME);

    $diagram
        ->class($class)
        ->cssClass(CSS_CLASS, CLASS_NAME)
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '  cssClass "' . CLASS_NAME . '" ' . CSS_CLASS . "\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with relationship', function (RelationshipType $relationship) {
    $diagram = new ClassDiagram();
    $class1 = new Classs(CLASS_NAME . '1');
    $class2 = new Classs(CLASS_NAME . '2');

    $diagram
        ->class($class1)
        ->class($class2)
        ->relationship(new Relationship($class1, $class2, $relationship))
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . "1 {\n"
            . "  }\n"
            . '  class ' . CLASS_NAME . "2 {\n"
            . "  }\n"
            . '  ' . CLASS_NAME . '1 ' . $relationship->value . ' ' . CLASS_NAME . "2\n"
            . '</pre>'
        )
    ;
})
  ->with('relationshipType')
;

test('classDiagram with everything', function () {
    $diagram = new ClassDiagram(title: TITLE, note: NOTE);
    $class1 = new Classs(CLASS_NAME . '1');
    $class2 = new Classs(CLASS_NAME . '2');
    $class3 = new Classs(CLASS_NAME . '3');
    $class4 = new Classs(CLASS_NAME . '4');

    $diagram
        ->class($class1, NAMESPACED . '1')
        ->class($class2, NAMESPACED . '1')
        ->class($class3, NAMESPACED . '2')
        ->class($class4, NAMESPACED . '2')
        ->relationship(new Relationship($class1, $class2, RelationshipType::Inheritance))
        ->relationship(new Relationship($class2, $class3, RelationshipType::Inheritance))
        ->relationship(new Relationship($class2, $class4, RelationshipType::Inheritance))
        ->cssClass(CSS_CLASS . '1', CLASS_NAME . '1')
        ->cssClass(CSS_CLASS . '2', CLASS_NAME . '2')
        ->cssClass(CSS_CLASS . '3', [CLASS_NAME . '3', CLASS_NAME . '4'])
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . TITLE . "\n"
            . "---\n"
            . "classDiagram\n"
            . '  namespace ' . NAMESPACED . "1 {\n"
            . '    class ' . CLASS_NAME . "1 {\n"
            . "    }\n"
            . '    class ' . CLASS_NAME . "2 {\n"
            . "    }\n"
            . "  }\n"
            . '  namespace ' . NAMESPACED . "2 {\n"
            . '    class ' . CLASS_NAME . "3 {\n"
            . "    }\n"
            . '    class ' . CLASS_NAME . "4 {\n"
            . "    }\n"
            . "  }\n"
            . '  ' . CLASS_NAME . '1 ' . RelationshipType::Inheritance->value . ' ' . CLASS_NAME . "2\n"
            . '  ' . CLASS_NAME . '2 ' . RelationshipType::Inheritance->value . ' ' . CLASS_NAME . "3\n"
            . '  ' . CLASS_NAME . '2 ' . RelationshipType::Inheritance->value . ' ' . CLASS_NAME . "4\n"
            . '  cssClass "' . CLASS_NAME . '1" ' . CSS_CLASS . "1\n"
            . '  cssClass "' . CLASS_NAME . '2" ' . CSS_CLASS . "2\n"
            . '  cssClass "' . CLASS_NAME . '3,' . CLASS_NAME . '4" ' . CSS_CLASS . "3\n"
            . '  note "' . NOTE . "\"\n"
            . '</pre>'
        )
    ;
});

dataset('relationshipType', [
    RelationshipType::Aggregation,
    RelationshipType::Association,
    RelationshipType::Composition,
    RelationshipType::DashedLink,
    RelationshipType::Dependency,
    RelationshipType::Inheritance,
    RelationshipType::Realization,
    RelationshipType::SolidLink,
]);
