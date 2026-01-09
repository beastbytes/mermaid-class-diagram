<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final class Attribute extends Member
{
    public const bool IS_STATIC = true;
    private const string ATTRIBUTE = '%s%s%s%s';

    public function __construct(
        protected readonly string $name,
        private readonly ?string $type = null,
        protected readonly ?Visibility $visibility = null,
        protected readonly bool $isStatic = false
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation . sprintf(
            self::ATTRIBUTE,
            $this->visibility instanceof Visibility ? $this->visibility->value : '',
            is_string($this->type) ? $this->type . ' ' : '',
            $this->name,
            $this->isStatic ? Classifier::static->value : ''
        );
    }
}