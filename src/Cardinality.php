<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum Cardinality: string
{
    case Many = '*';
    case N = 'n';
    case OneOrMore = '1..*';
    case OneToN = '1..n';
    case Only1 = '1';
    case ZeroOrOne = '0..1';
    case ZeroToN = '0..n';
}
