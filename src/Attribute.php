<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final readonly class Attribute
{
    public function __construct(
        private string $name,
        private ?string $type = null,
        private ?Visibility $visibility = null
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation
            . ($this->visibility === null ? '' : $this->visibility->value)
            . ($this->type === null ? '' : $this->type . ' ')
            . $this->name
        ;
    }
}