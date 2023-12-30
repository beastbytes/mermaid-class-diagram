<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\StyleTrait;
use Stringable;

final class ClassDiagram implements MermaidInterface, Stringable
{
    private const NAMESPACE = "%snamespace %s {\n%s\n%s}";
    private const NOTE = '%snote "%s"';
    private const TITLE_DELIMITER = '---';
    private const TYPE = 'classDiagram';

    /** @var array<string, Classs[]> */
    private array $classes = [];
    /** @var Relationship[] */
    private array $relationships = [];

    public function __construct(
        private readonly string $title = '',
        private readonly string $note = '',
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

    public function render(): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        if ($this->title !== '') {
            $output[] = self::TITLE_DELIMITER;
            $output[] = $this->title;
            $output[] = self::TITLE_DELIMITER;
        }

        $output[] = self::TYPE;

        foreach ($this->classes as $namespace => $namespacedClasses) {
            $classes = [];
            $indentation = $namespace === Classs::DEFAULT_NAMESPACE
                ? Mermaid::INDENTATION
                : str_repeat(Mermaid::INDENTATION, 2)
            ;

            foreach ($namespacedClasses as $namespacedClass) {
                $classes[] = $namespacedClass->render($indentation);
            }

            if ($namespace === Classs::DEFAULT_NAMESPACE) {
                $output[] = implode("\n", $classes);
            } else {
                $output[] = sprintf(
                    self::NAMESPACE,
                    Mermaid::INDENTATION,
                    $namespace,
                    implode("\n", $classes),
                    Mermaid::INDENTATION
                );
            }
        }

        foreach ($this->relationships as $relationship) {
            $output[] = $relationship->render(Mermaid::INDENTATION);
        }

        if ($this->note !== '') {
            $output[] = sprintf(self::NOTE, Mermaid::INDENTATION, $this->note);
        }

        return Mermaid::render($output);
    }
}
