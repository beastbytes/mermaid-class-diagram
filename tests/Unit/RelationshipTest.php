<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

use BeastBytes\Mermaid\ClassDiagram\Cardinality;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Relationship;
use BeastBytes\Mermaid\ClassDiagram\RelationshipType;
use BeastBytes\Mermaid\Mermaid;

const CLASS_A_NAME = 'ClassA';
const CLASS_B_NAME = 'ClassB';
const LABEL = 'Label';

test('Simple relationship', function (RelationshipType $type) {
    $classA = new Classs(CLASS_A_NAME);
    $classB = new Classs(CLASS_B_NAME);

    $relationship = new Relationship($classA, $classB, $type);

    expect($relationship->render(''))
        ->toBe($classA->getId() . ' ' . $type->value . ' ' . $classB->getId())
    ;
})
    ->with('relationshipType')
;

test('Relationship with label', function () {
    $classA = new Classs(CLASS_A_NAME);
    $classB = new Classs(CLASS_B_NAME);

    $relationship = new Relationship($classA, $classB, RelationshipType::Inheritance, LABEL);

    expect($relationship->render(''))
        ->toBe($classA->getId()
            . ' ' . RelationshipType::Inheritance->value
            . ' ' . $classB->getId()
            . ' : ' . LABEL
        )
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
    Cardinality::Many,
    Cardinality::N,
    Cardinality::OneOrMore,
    Cardinality::OneToN,
    Cardinality::Only1,
    Cardinality::ZeroOrOne,
    Cardinality::ZeroToN,
]);

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
