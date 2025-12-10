<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\NodeInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\StyleClassTrait;

final class Classs implements InteractionInterface, NodeInterface
{
    use CommentTrait;
    use InteractionTrait;
    use RenderItemsTrait;
    use StyleClassTrait;

    public const DEFAULT_NAMESPACE = '';
    private const TYPE = 'class';

    /** @psalm-var list<Attribute|Method>  */
    private array $members = [];
    private string $note = '';

    public function __construct(
        private readonly string $name,
        private readonly string $annotation = '',
        private readonly string $label = '',
        private readonly string $namespace = self::DEFAULT_NAMESPACE
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @internal */
    public function getNamespace(): string
    {
        return $this->namespace;
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

    public function withNote(string $note): self
    {
        $new = clone $this;
        $new->note = $note;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $this->renderComment($indentation, $output);

        $output[] = $indentation
            . self::TYPE
            . ' '
            . $this->name
            . ($this->label === '' ? '' : '["' . $this->label . '"]')
            . $this->getStyleClass()
            . ' {'
        ;

        if ($this->annotation !== '') {
            $output[] = $indentation . Mermaid::INDENTATION . '<<' . $this->annotation . '>>';
        }

        $this->renderItems($this->members, $indentation, $output);

        $output[] = $indentation . '}';

        return implode("\n", $output);
    }

    /** @internal */
    public function renderNote(string $indentation, array &$output): void
    {
        if ($this->note !== '') {
            $output[] = $indentation . 'note for ' . $this->name . ' "' . $this->note . '"';
        }
    }
}
