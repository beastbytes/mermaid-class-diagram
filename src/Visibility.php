<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum Visibility: string
{
    case Public = '+';
    case Private = '-';
    case Protected = '#';
    case Internal = '~';
}
