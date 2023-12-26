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
    private const NAMESPACE = "namespace %s {\n%s\n}";
    private const NOTE = 'note "%s"';
    private const STYLE_CLASS = 'cssClass, "%s" %s';
    private const TITLE_DELIMITER = '---';
    private const TYPE = 'classDiagram';

    private array $classes = [];
    private array $relationships = [];
    private array $styleClasses = [];

    public function __construct(
        private readonly string $namespace = '',
        private readonly string $note = '',
        private readonly string $title = '',
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function class(Classs $class): self
    {
        $this->classes[] = $class;
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

        $classes = [];
        foreach ($this->classes as $class) {
            $classes[] = $class->render(Mermaid::INDENTATION);
        }

        if ($this->namespace !== '') {
            $output[] = sprintf(self::NAMESPACE, $this->namespace, implode("\n", $classes));
        } else {
            $output[] = implode("\n", $classes);
        }

        foreach ($this->relationships as $relationship) {
            $output[] = $relationship->render(Mermaid::INDENTATION);
        }

        foreach ($this->styleClasses as $styleClass => $classes) {
            $output[] = sprintf(self::STYLE_CLASS, implode(',', $classes) , $styleClass);
        }

        if ($this->note !== '') {
            $output[] = sprintf(self::NOTE, $this->note);
        }

        return Mermaid::render(implode("\n", $output));
    }
}
