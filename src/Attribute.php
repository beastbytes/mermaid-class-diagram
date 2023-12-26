<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

final class Attribute implements MemberInterface
{
    private const ATTRIBUTE = '%s%s%s%s';

    public function __construct(
        private readonly string $name,
        private readonly ?string $type = null,
        private readonly ?Visibility $visibility = null
    )
    {
    }
    public function render(string $indentation): string
    {
        return sprintf(
            self::ATTRIBUTE,
            $indentation,
            $this->visibility === null ? '' : $this->visibility->value,
            $this->type === null ? '' : $this->type . ' ',
            $this->name
        );
    }
}
