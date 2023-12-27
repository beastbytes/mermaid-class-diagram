<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\Mermaid;

use const PHP_EOL;

final class Classs
{
    private const ANNOTATION = '%s<<%s>>';
    private const BEGIN_CLASS = '%s%s %s%s {';
    private const END_CLASS = '%s}';
    private const LABEL = '["%s"]';
    private const NOTE = '%snote for %s "%s"';
    private const TYPE = 'class';

    private array $members = [];

    public function __construct(
        private readonly string $name,
        private readonly string $annotation = '',
        private readonly string $label = '',
        private readonly string $note = ''
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function member(Attribute|Method $member): self
    {
        $this->members[] = $member;
        return $this;
    }

    public function render(string $indentation): string
    {
        $output = [];

        $output[] = sprintf(
            self::BEGIN_CLASS,
            $indentation,
            self::TYPE,
            $this->name,
            $this->label === '' ? '' : sprintf(self::LABEL, $this->label)
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
