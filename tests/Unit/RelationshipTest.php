<?php

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Cardinality;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Relationship;
use BeastBytes\Mermaid\ClassDiagram\RelationshipType;

defined('CLASS_A_NAME') or define('CLASS_A_NAME', 'ClassA');
defined('CLASS_B_NAME') or define('CLASS_B_NAME', 'ClassB');
defined('LABEL') or define('LABEL', 'Label');

test('Simple relationship', function (RelationshipType $type) {
    $classA = new Classs(CLASS_A_NAME);
    $classB = new Classs(CLASS_B_NAME);

    $relationship = new Relationship($classA, $classB, $type);

    expect($relationship->render(''))
        ->toBe('ClassA ' . $type->value . ' ClassB')
    ;
})
    ->with('relationshipType')
;

test('Relationship with label', function () {
    $classA = new Classs(CLASS_A_NAME);
    $classB = new Classs(CLASS_B_NAME);

    $relationship = new Relationship($classA, $classB, RelationshipType::inheritance, LABEL);

    expect($relationship->render(''))
        ->toBe('ClassA --|> ClassB : Label')
    ;
});

test('Relationship with cardinality', function ($type, $cardinalityA , $cardinalityB) {
    $classA = new Classs(CLASS_A_NAME);
    $classB = new Classs(CLASS_B_NAME);

    $relationship = new Relationship(
        $classA,
        $classB,
        $type,
        LABEL,
        $cardinalityA,
        $cardinalityB
);

    expect($relationship->render(''))
        ->toBe($classA->getId()
            . ' "' . $cardinalityA->value . '"'
            . ' ' . $type->value
            . ' "' . $cardinalityB->value . '"'
            . ' ' . $classB->getId()
            . ' : ' . LABEL
    );
})
    ->with('relationshipType')
    ->with('cardinality')
    ->with('cardinality')
;

dataset('cardinality', [
    Cardinality::many,
    Cardinality::n,
    Cardinality::oneOrMore,
    Cardinality::oneToN,
    Cardinality::only1,
    Cardinality::zeroOrOne,
    Cardinality::zeroToN,
]);

dataset('relationshipType', [
    RelationshipType::aggregation,
    RelationshipType::association,
    RelationshipType::composition,
    RelationshipType::dashedLink,
    RelationshipType::dependency,
    RelationshipType::inheritance,
    RelationshipType::realization,
    RelationshipType::solidLink,
]);