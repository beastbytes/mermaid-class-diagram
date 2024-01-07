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

    /** @var array<string, Classs[]> */
    private array $classes = [];
    /** @var Relationship[] */
    private array $relationships = [];
    private ?Note $note = null;

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

    public function withNote(Note $note): self
    {
        $new = clone $this;
        $new->note = $note;
        return $new;
    }

    public function render(): string
    {
        $output = [];

        if ($this->title !== '') {
            $output[] = $this->getTitle();
        }

        $output[] = self::TYPE;

        foreach ($this->classes as $namespace => $namespacedClasses) {
            if ($namespace === Classs::DEFAULT_NAMESPACE) {
                $output[] = $this->renderItems($namespacedClasses, '');
            } else {
                $output[] = Mermaid::INDENTATION
                    . "namespace $namespace {\n"
                    . $this->renderItems($namespacedClasses, Mermaid::INDENTATION) . "\n"
                    . Mermaid::INDENTATION . '}'
                ;
            }
        }

        if (count($this->relationships) > 0) {
            $output[] = $this->renderItems($this->relationships, '');
        }

        if ($this->note !== null) {
            $output[] = $this->note->render(Mermaid::INDENTATION);
        }

        if (!empty($this->classDefs)) {
            $output[] = $this->renderClassDefs(Mermaid::INDENTATION);
        }

        return Mermaid::render($output);
    }
}
