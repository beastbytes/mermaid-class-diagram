<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final readonly class Method
{
    public function __construct(
        private string $name,
        private array $parameters = [],
        private ?string $returnType = null,
        private ?Visibility $visibility = null
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation
            . ($this->visibility === null ? '' : $this->visibility->value)
            . $this->name
            . '(' . implode(', ', $this->parameters) . ')'
            . ($this->returnType === null ? '' : ' ' . $this->returnType)
        ;
    }
}