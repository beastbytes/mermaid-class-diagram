<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\IdTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\StyleClassTrait;

final class Classs implements InteractionInterface
{
    use CommentTrait;
    use IdTrait;
    use InteractionTrait;
    use RenderItemsTrait;
    use StyleClassTrait;

    public const string DEFAULT_NAMESPACE = '';
    private const string ANNOTATION = '<<%s>>';
    private const string LABEL = '["%s"]';
    private const string NOTE = 'note for %s "%s"';
    private const string TYPE = 'class';

    /** @psalm-var list<Attribute|Method> */
    private array $members = [];
    private ?string $note = null;

    public function __construct(
        string $name,
        private readonly ?string $annotation = null,
        private readonly ?string $label = null,
        private readonly ?string $namespace = null
    )
    {
        $this->id = $name;
    }

    /** @internal */
    public function getName(): string
    {
        return $this->getId();
    }

    /** @internal */
    public function getNamespace(): string
    {
        return is_string($this->namespace) ? $this->namespace : self::DEFAULT_NAMESPACE;
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

        $output[] = $this->renderComment($indentation);
        $output[] = $indentation
            . self::TYPE
            . ' '
            . $this->getId()
            . (is_string($this->label) ? sprintf(self::LABEL, $this->label) : '')
            . $this->getStyleClass()
            . ' {';
        $output[] = is_string($this->annotation)
            ? $indentation . Mermaid::INDENTATION . sprintf(self::ANNOTATION, $this->annotation)
            : ''
        ;
        $output[] = $this->renderItems($this->members, $indentation);
        $output[] = $indentation . '}';

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }

    /** @internal */
    public function hasNote(): bool
    {
        return is_string($this->note);
    }

    /** @internal */
    public function renderNote(string $indentation): ?string
    {
        return is_string($this->note) ? $indentation . sprintf(self::NOTE, $this->getId(), $this->note) : null;
    }
}