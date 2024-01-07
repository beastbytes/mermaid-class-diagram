<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\ClassDiagram;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Note;
use BeastBytes\Mermaid\ClassDiagram\Relationship;
use BeastBytes\Mermaid\ClassDiagram\RelationshipType;

const CLASS_NAME = 'TestClass';
const CLASS_NAMESPACE = 'ClassNamespace';
const TITLE = 'Title';
const NOTE = 'Note';

test('Simple classDiagram', function () {
    $class = new Classs(CLASS_NAME);

    $diagram = (new ClassDiagram())
        ->withClass($class)
    ;

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
    $class = new Classs(name: CLASS_NAME, namespace:CLASS_NAMESPACE);

    $diagram = (new ClassDiagram())
        ->withClass($class)
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  namespace ' . CLASS_NAMESPACE . " {\n"
            . '    class ' . CLASS_NAME . " {\n"
            . "    }\n"
           . "  }\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with note', function () {
    $class = new Classs(CLASS_NAME);

    $diagram = (new ClassDiagram())
        ->withNote(new Note(NOTE))
        ->withClass($class)
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '  note &quot;' . NOTE . "&quot;\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with title', function () {
    $class = new Classs(CLASS_NAME);

    $diagram = (new ClassDiagram(title: TITLE))
        ->withClass($class)
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . 'title: ' . TITLE . "\n"
            . "---\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with relationship', function (RelationshipType $relationship) {
    $class1 = new Classs(CLASS_NAME . '1');
    $class2 = new Classs(CLASS_NAME . '2');

    $diagram = (new ClassDiagram())
        ->withClass($class1, $class2)
        ->withRelationship(new Relationship($class1, $class2, $relationship))
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  class ' . CLASS_NAME . "1 {\n"
            . "  }\n"
            . '  class ' . CLASS_NAME . "2 {\n"
            . "  }\n"
            . '  ' . CLASS_NAME . '1 ' . htmlspecialchars($relationship->value) . ' ' . CLASS_NAME . "2\n"
            . '</pre>'
        )
    ;
})
  ->with('relationshipType')
;

test('classDiagram with everything', function () {
    $class1 = (new Classs(name: CLASS_NAME . '1', namespace: CLASS_NAMESPACE . '1'))
        ->withStyleClass('classDef0')
    ;
    $class2 = (new Classs(name: CLASS_NAME . '2', namespace: CLASS_NAMESPACE . '1'))
        ->withStyleClass('classDef2')
    ;
    $class3 = (new Classs(name: CLASS_NAME . '3', namespace: CLASS_NAMESPACE . '2'))
        ->withStyleClass('classDef1')
    ;
    $class4 = (new Classs(name: CLASS_NAME . '4', namespace: CLASS_NAMESPACE . '2'));

    $diagram = (new ClassDiagram(title: TITLE))
        ->withNote(new Note(NOTE))
        ->withClass($class1, $class2, $class3, $class4)
        ->withRelationship(
            new Relationship($class1, $class2, RelationshipType::Inheritance),
            new Relationship($class2, $class3, RelationshipType::Inheritance),
            new Relationship($class2, $class4, RelationshipType::Inheritance)
        )
        ->withClassDef([
            'classDef0' => 'fill:white',
            'classDef1' => ['font-style' => 'italic']
        ])
        ->addClassDef(['classDef2' => [
            'fill' => '#f00',
            'color' => 'white',
            'font-weight' => 'bold',
            'stroke-width' => '2px',
            'stroke' => 'yellow'
        ]])
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . 'title: ' . TITLE . "\n"
            . "---\n"
            . "classDiagram\n"
            . '  namespace ' . CLASS_NAMESPACE . "1 {\n"
            . '    class ' . CLASS_NAME . "1:::classDef0 {\n"
            . "    }\n"
            . '    class ' . CLASS_NAME . "2:::classDef2 {\n"
            . "    }\n"
            . "  }\n"
            . '  namespace ' . CLASS_NAMESPACE . "2 {\n"
            . '    class ' . CLASS_NAME . "3:::classDef1 {\n"
            . "    }\n"
            . '    class ' . CLASS_NAME . "4 {\n"
            . "    }\n"
            . "  }\n"
            . '  ' . CLASS_NAME . '1 --|&gt; ' . CLASS_NAME . "2\n"
            . '  ' . CLASS_NAME . '2 --|&gt; ' . CLASS_NAME . "3\n"
            . '  ' . CLASS_NAME . '2 --|&gt; ' . CLASS_NAME . "4\n"
            . '  note &quot;' . NOTE . "&quot;\n"
            . "  classDef classDef0 fill:white;\n"
            . "  classDef classDef1 font-style:italic;\n"
            . "  classDef classDef2 fill:#f00,color:white,font-weight:bold,stroke-width:2px,stroke:yellow;\n"
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
