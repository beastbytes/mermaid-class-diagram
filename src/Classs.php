<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\Mermaid;

use BeastBytes\Mermaid\NodeInterface;

use BeastBytes\Mermaid\StyleClassTrait;

use const PHP_EOL;

final class Classs
{
    use StyleClassTrait;

    public const DEFAULT_NAMESPACE = '|default|';
    private const ANNOTATION = '%s<<%s>>';
    private const BEGIN_CLASS = '%s%s %s%s%s {';
    private const END_CLASS = '%s}';
    private const LABEL = '["%s"]';
    private const NOTE = '%snote for %s "%s"';
    private const TYPE = 'class';

    /** @psalm-var list<Attribute|Method>  */
    private array $members = [];

    public function __construct(
        private readonly string $name,
        private readonly string $annotation = '',
        private readonly string $label = '',
        private readonly string $note = '',
        private readonly string $namespace = self::DEFAULT_NAMESPACE,
        private readonly string $styleClass = ''
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * Add one or many members to the current set
     *
     * @psalm-suppress PropertyTypeCoercion
     *
     * @param Attribute|Method ...$member One or many members
     * @return Classs
     */
    public function addMember(Attribute|Method ...$member): self
    {
        $new = clone $this;
        $new->members = array_merge($new->members, $member);
        return $new;
    }

    /**
     * Replace current members with a new set
     *
     * @psalm-suppress PropertyTypeCoercion
     *
     * @param Attribute|Method ...$member One or many members
     * @return Classs
     */
    public function withMember(Attribute|Method ...$member): self
    {
        $new = clone $this;
        $new->members = $member;
        return $new;
    }

    /**
     * @internal
     */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = sprintf(
            self::BEGIN_CLASS,
            $indentation,
            self::TYPE,
            $this->name,
            $this->label === '' ? '' : sprintf(self::LABEL, $this->label),
            $this->getStyleClass()
        );

        if ($this->annotation !== '') {
            $output[] = sprintf(
                self::ANNOTATION,
                $indentation . Mermaid::INDENTATION, $this->annotation
            );
        }

        foreach ($this->members as $member) {
            $output[] = $member->render($indentation . Mermaid::INDENTATION);
        }

        $output[] = sprintf(self::END_CLASS, $indentation);

        if ($this->note !== '') {
            $output[] = sprintf(self::NOTE, $indentation, $this->name, $this->note);
        }

        return implode("\n", $output);
    }
}
