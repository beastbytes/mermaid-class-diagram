<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final class Relationship
{
    private const RELATIONSHIP = '%s%s%s%s%s%s%s';

    public function __construct(
        private readonly Classs $classA,
        private readonly Classs $classB,
        private readonly RelationshipType $type,
        private readonly ?string $label = null,
        private readonly ?Cardinality $cardinalityA = null,
        private readonly ?Cardinality $cardinalityB = null
    )
    {
    }

    public function render(string $indentation): string
    {
        return sprintf(
            self::RELATIONSHIP,
            $indentation,
            $this->classA->getName() . ' ',
            $this->cardinalityA === null ? '' : '"' . $this->cardinalityA->value . '" ',
            $this->type->value . ' ',
            $this->cardinalityB === null ? '' : '"' . $this->cardinalityB->value . '" ',
            $this->classB->getName(),
            $this->label === null ? '' : ' : ' . $this->label
        );
    }
}
