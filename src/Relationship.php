<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final readonly class Relationship
{
    public function __construct(
        private Classs $classA,
        private Classs $classB,
        private RelationshipType $type,
        private ?string $label = null,
        private ?Cardinality $cardinalityA = null,
        private ?Cardinality $cardinalityB = null
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation
            . $this->classA->getId()
            . ' '
            . ($this->cardinalityA instanceof Cardinality ? '"' . $this->cardinalityA->value . '" ' : '')
            . $this->type->value
            . ' '
            . ($this->cardinalityB instanceof Cardinality ? '"' . $this->cardinalityB->value . '" ' : '')
            . $this->classB->getId()
            . (is_string($this->label) ? ' : ' . $this->label : '')
        ;
    }
}