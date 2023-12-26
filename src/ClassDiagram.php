<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use Stringable;

class ClassDiagram implements MermaidInterface, Stringable
{
    private const DEFAULT_NAMESPACE = 'default';
    private const NAMESPACE = "%snamespace %s {\n%s\n%s}";
    private const NOTE = '%snote "%s"';
    private const STYLE_CLASS = '%scssClass "%s" %s';
    public const TITLE_DELIMITER = '---';
    private const TYPE = 'classDiagram';

    private array $classes = [];
    private array $relationships = [];
    private array $styleClasses = [];

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

    public function class(Classs $class, string $namespace = self::DEFAULT_NAMESPACE): self
    {
        $this->classes[$namespace][] = $class;
        return $this;
    }

    public function cssClass(string $styleClass, array|string $class): self
    {
        if (is_string($class)) {
            $class = explode(',', str_replace(' ', '', $class));
        }

        $this->styleClasses[$styleClass] = $class;
        return $this;
    }

    public function relationship(Relationship $relationship): self
    {
        $this->relationships[] = $relationship;
        return $this;
    }

    public function render(): string
    {
        $output = [];

        if ($this->title !== '') {
            $output[] = self::TITLE_DELIMITER;
            $output[] = $this->title;
            $output[] = self::TITLE_DELIMITER;
        }

        $output[] = self::TYPE;

        foreach ($this->classes as $namespace => $namespacedClasses) {
            $classes = [];
            $indentation = $namespace === self::DEFAULT_NAMESPACE
                ? Mermaid::INDENTATION
                : str_repeat(Mermaid::INDENTATION, 2)
            ;

            foreach ($namespacedClasses as $namespacedClass) {
                $classes[] = $namespacedClass->render($indentation);
            }

            if ($namespace === self::DEFAULT_NAMESPACE) {
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

        foreach ($this->styleClasses as $styleClass => $classes) {
            $output[] = sprintf(
                self::STYLE_CLASS,
                Mermaid::INDENTATION,
                implode(',', $classes),
                $styleClass
            );
        }

        if ($this->note !== '') {
            $output[] = sprintf(self::NOTE, Mermaid::INDENTATION, $this->note);
        }

        return Mermaid::render(implode("\n", $output));
    }
}
