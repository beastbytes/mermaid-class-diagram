<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\TitleTrait;
use Stringable;

final class ClassDiagram implements MermaidInterface, Stringable
{
    use CommentTrait;
    use InteractionRendererTrait;
    use RenderItemsTrait;
    use TitleTrait;

    private const TYPE = 'classDiagram';

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
    private string $note = '';

    public function __toString(): string
    {
        return $this->render();
    }

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

    public function render(array $attributes = []): string
    {
        $output = [];

        $this->renderTitle($output);
        $this->renderComment('', $output);

        $output[] = self::TYPE;

        if ($this->note !== '') {
            $output[] = Mermaid::INDENTATION . 'note "' . $this->note . '"';
        }

        foreach ($this->classes as $namespace => $classes) {
            if ($namespace === Classs::DEFAULT_NAMESPACE) {
                $this->renderItems($classes, '', $output);
            } else {
                $output[] = Mermaid::INDENTATION . "namespace $namespace {";
                $this->renderItems($classes, Mermaid::INDENTATION, $output);
                $output[] = Mermaid::INDENTATION . '}';
            }
            $this->renderNotes($classes, $output);
            $this->renderInteractions($classes, $output);
        }

        $this->renderItems($this->relationships, '', $output);

        return Mermaid::render($output, $attributes);
    }

    private function renderNotes(array $classes, &$output): void
    {
        /** @var Classs $class */
        foreach ($classes as $class) {
            $class->renderNote(Mermaid::INDENTATION, $output);
        }
    }
}
