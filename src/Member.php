<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

abstract class Member
{
    /** @internal */
    public function getName(): string
    {
        return $this->name;
    }

    /** @internal */
    public function getVisibility(): Visibility
    {
        return $this->visibility ?? Visibility::public;
    }

    /** @internal  */
    public function isAbstract(): bool
    {
        return property_exists($this, 'isAbstract') && $this->isAbstract;
    }

    /** @internal  */
    public function isStatic(): bool
    {
        return $this->isStatic;
    }

    abstract public function render(string $indentation): string;
}