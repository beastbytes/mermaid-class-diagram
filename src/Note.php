<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\Mermaid;

final class Note
{
    public function __construct(
        private readonly string $note
    )
    {
    }

    /** @internal  */
    public function render(string $indentation, ?Classs $class = null): string
    {
        return $indentation
            . 'note'
            . ($class === null ? '' : ' for ' . $class->getName())
            . ' "' . $this->note . '"'
        ;
    }
}
