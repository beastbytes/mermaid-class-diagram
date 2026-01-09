<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final class Method extends Member
{
    public const bool IS_ABSTRACT = true;
    public const bool IS_STATIC = true;
    private const string METHOD = '%s%s(%s)%s%s%s';

    public function __construct(
        protected readonly string $name,
        /** @psalm-param array<int|string, string> $parameters */
        private readonly array $parameters = [],
        private readonly ?string $returnType = null,
        protected readonly ?Visibility $visibility = null,
        protected readonly bool $isAbstract = false,
        protected readonly bool $isStatic = false,
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $parameters = [];

        foreach ($this->parameters as $name => $type) {
            if (is_int($name)) {
                $name = $type;
                $type = null;
            }

            $parameters[] = (is_string($type) ? str_replace(['<', '>'], '~', $type) . ' ' : '') . $name;
        }

        return $indentation . sprintf(
            self::METHOD,
            $this->visibility instanceof Visibility ? $this->visibility->value : '',
            $this->name,
            implode(', ', $parameters),
            is_string($this->returnType) ? ' ' . str_replace(['<', '>'], '~', $this->returnType) : '',
            $this->isAbstract ? Classifier::abstract->value : '',
            $this->isStatic ? Classifier::static->value : '',
        );
    }
}