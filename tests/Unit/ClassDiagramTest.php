<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\ClassDiagram;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Relationship;
use BeastBytes\Mermaid\ClassDiagram\RelationshipType;

const CLASS_NAME = 'TestClass';
const CLASS_NAMESPACE = 'ClassNamespace';
const TITLE = 'Title';
const NOTE = 'Note';

test('Simple classDiagram', function () {
    $diagram = (new ClassDiagram())
        ->withClass(new Classs(CLASS_NAME))
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
    $diagram = (new ClassDiagram())
        ->withClass(new Classs(name: CLASS_NAME, namespace:CLASS_NAMESPACE))
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
    $diagram = (new ClassDiagram())
        ->withNote(NOTE)
        ->withClass(new Classs(CLASS_NAME))
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "classDiagram\n"
            . '  note &quot;' . NOTE . "&quot;\n"
            . '  class ' . CLASS_NAME . " {\n"
            . "  }\n"
            . '</pre>'
        )
    ;
});

test('classDiagram with title', function () {
    $diagram = (new ClassDiagram())
        ->withClass(new Classs(CLASS_NAME))
        ->withTitle(TITLE)
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
    $diagram = (new ClassDiagram())
        ->withClass(
            $class1 = new Classs(CLASS_NAME . '1'),
            $class2 = new Classs(CLASS_NAME . '2')
        )
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
    $diagram = (new ClassDiagram())
        ->withNote(NOTE)
        ->withTitle(TITLE)
        ->withClass(
            $class1 = (new Classs(name: CLASS_NAME . '1', namespace: CLASS_NAMESPACE . '1'))
                ->withStyleClass('classDef0')
            ,
            $class2 = (new Classs(name: CLASS_NAME . '2', namespace: CLASS_NAMESPACE . '1'))
                ->withStyleClass('classDef2')
                ->withNote("Class 2 note")
                ->withInteraction('https://example.com')
            ,
            $class3 = (new Classs(name: CLASS_NAME . '3', namespace: CLASS_NAMESPACE . '2'))
                ->withStyleClass('classDef1')
                ->withNote("Class 3 note")
            ,
            $class4 = (new Classs(name: CLASS_NAME . '4', namespace: CLASS_NAMESPACE . '2'))
                ->withInteraction('https://example.com')
        )
        ->withRelationship(
            new Relationship($class1, $class2, RelationshipType::Inheritance),
            new Relationship($class2, $class3, RelationshipType::Inheritance),
            new Relationship($class2, $class4, RelationshipType::Inheritance)
        )
    ;

    expect($diagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . 'title: ' . TITLE . "\n"
            . "---\n"
            . "classDiagram\n"
            . '  note &quot;' . NOTE . "&quot;\n"
            . '  namespace ' . CLASS_NAMESPACE . "1 {\n"
            . '    class ' . CLASS_NAME . "1:::classDef0 {\n"
            . "    }\n"
            . '    class ' . CLASS_NAME . "2:::classDef2 {\n"
            . "    }\n"
            . "  }\n"
            . "  note for TestClass2 &quot;Class 2 note&quot;\n"
            . "  click TestClass2 href &quot;https://example.com&quot;\n"
            . '  namespace ' . CLASS_NAMESPACE . "2 {\n"
            . '    class ' . CLASS_NAME . "3:::classDef1 {\n"
            . "    }\n"
            . '    class ' . CLASS_NAME . "4 {\n"
            . "    }\n"
            . "  }\n"
            . "  note for TestClass3 &quot;Class 3 note&quot;\n"
            . "  click TestClass4 href &quot;https://example.com&quot;\n"
            . '  ' . CLASS_NAME . '1 --|&gt; ' . CLASS_NAME . "2\n"
            . '  ' . CLASS_NAME . '2 --|&gt; ' . CLASS_NAME . "3\n"
            . '  ' . CLASS_NAME . '2 --|&gt; ' . CLASS_NAME . "4\n"
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
