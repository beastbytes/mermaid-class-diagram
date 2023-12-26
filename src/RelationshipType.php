<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum RelationshipType: string
{
    case Aggregation = '--o';
    case Association = '-->';
    case Composition = '--*';
    case DashedLink = '..';
    case Dependency = '..>';
    case Inheritance = '--|>';
    case Realization = '..|>';
    case SolidLink = '--';
}
