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
            . $this->classA->getName()
            . ' '
            . ($this->cardinalityA === null ? '' : '"' . $this->cardinalityA->value . '" ')
            . $this->type->value
            . ' '
            . ($this->cardinalityB === null ? '' : '"' . $this->cardinalityB->value . '" ')
            . $this->classB->getName()
            . ($this->label === null ? '' : ' : ' . $this->label)
        ;
    }
}