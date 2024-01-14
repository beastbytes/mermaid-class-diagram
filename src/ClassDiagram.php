<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\ClassDefTrait;
use BeastBytes\Mermaid\TitleTrait;
use Stringable;

final class ClassDiagram implements MermaidInterface, Stringable
{
    use ClassDefTrait;
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
    /**
     * @psalm-var list<string> $notes
     * @var string[] $notes
     */
    private array $notes = [];

    public function __construct(
        private readonly string $title = ''
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Add one or many relationships to the current set
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
        $new->notes[] = 'note "' . $note . '"';
        return $new;
    }

    public function render(): string
    {
        $output = [];

        if ($this->title !== '') {
            $output[] = $this->getTitle();
        }

        $output[] = self::TYPE;

        foreach ($this->classes as $namespace => $classes) {
            if ($namespace === Classs::DEFAULT_NAMESPACE) {
                $output[] = $this->renderItems($classes, '');
            } else {
                $output[] = Mermaid::INDENTATION
                    . "namespace $namespace {\n"
                    . $this->renderItems($classes, Mermaid::INDENTATION) . "\n"
                    . Mermaid::INDENTATION . '}'
                ;
            }

            foreach ($classes as $class) {
                if ($class->hasAction()) {
                    $this->actions[] = $class->getAction();
                }
                if ($class->hasNote()) {
                    $this->notes[] = $class->getNote();
                }
            }
        }

        if (count($this->relationships) > 0) {
            $output[] = $this->renderItems($this->relationships, '');
        }

        foreach ($this->notes as $note) {
            $output[] = Mermaid::INDENTATION . $note;
        }

        foreach ($this->actions as $action) {
            $output[] = Mermaid::INDENTATION . $action;
        }

        if (!empty($this->classDefs)) {
            $output[] = $this->renderClassDefs(Mermaid::INDENTATION);
        }

        return Mermaid::render($output);
    }
}
