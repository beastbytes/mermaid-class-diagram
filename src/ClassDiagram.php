<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\Diagram;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;

final class ClassDiagram extends Diagram
{
    use CommentTrait;
    use InteractionRendererTrait;
    use RenderItemsTrait;

    private const string TYPE = 'classDiagram';

    /**
     * @psalm-var list<string> $actions
     * @var string[] $actions
     */
    private array $actions = [];
    /** @var array<string, Classs[]> $classes */
    private array $classes = [];
    /**
     * @psalm-var list<Relationship> $relationships
     * @var Relationship[] $relationships
     */
    private array $relationships = [];
    private ?string $note = null;

    /**
     * Add one or many classes to the current set
     *
     * @param Classs ...$class One or many classes
     * @return ClassDiagram
     */
    public function addClass(Classs ...$class): self
    {
        $new = clone $this;

        foreach ($class as $cls) {
            $new->classes[$cls->getNamespace()][] = $cls;
        }

        return $new;
    }

    /**
     * Replace current classes with a new set
     *
     * @param Classs ...$class One or many classes
     * @return ClassDiagram
     */
    public function withClass(Classs ...$class): self
    {
        $new = clone $this;
        $new->classes = [];

        foreach ($class as $cls) {
            $new->classes[$cls->getNamespace()][] = $cls;
        }

        return $new;
    }

    /**
     * Add one or many relationships to the current set
     *
     * @param Relationship ...$relationship One or many relationships
     * @return ClassDiagram
     */
    public function addRelationship(Relationship ...$relationship): self
    {
        $new = clone $this;
        $new->relationships = array_merge($this->relationships, $relationship);
        return $new;
    }

    /**
     * Replace current relationships with a new set
     *
     * @param Relationship ...$relationship One or many relationships
     * @return ClassDiagram
     */
    public function withRelationship(Relationship ...$relationship): self
    {
        $new = clone $this;
        $new->relationships = $relationship;
        return $new;
    }

    public function withNote(string $note): self
    {
        $new = clone $this;
        $new->note = $note;
        return $new;
    }

    private function renderNote(string $indentation): string
    {
        return is_string($this->note)
            ? $indentation . 'note "' . $this->note . '"'
            : ''
        ;
    }

    protected function renderDiagram(): string
    {
        $output = [];

        $output[] = $this->renderComment('');
        $output[] = self::TYPE;
        $output[] = $this->renderNote(Mermaid::INDENTATION);

        foreach ($this->classes as $namespace => $classes) {
            if ($namespace === Classs::DEFAULT_NAMESPACE) {
                $output[] = $this->renderItems($classes, '');
            } else {
                $output[] = Mermaid::INDENTATION . "namespace $namespace {";
                $output[] = $this->renderItems($classes, Mermaid::INDENTATION);
                $output[] = Mermaid::INDENTATION . '}';
            }

            $output[] = $this->renderNotes($classes);
            $output[] = $this->renderInteractions($classes);
        }

        $output[] = $this->renderItems($this->relationships, '');

        return implode("\n", array_filter($output, fn($v) => $v !== ''));
    }

    private function renderNotes(array $classes): string
    {
        $notes = [];

        /** @var Classs $class */
        foreach ($classes as $class) {
            if ($class->hasNote()) {
                $notes[] = $class->renderNote(Mermaid::INDENTATION);
            }
        }

        return implode("\n", $notes);
    }
}