<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum Cardinality: string
{
    case many = '*';
    case n = 'n';
    case oneOrMore = '1..*';
    case oneToN = '1..n';
    case only1 = '1';
    case zeroOrOne = '0..1';
    case zeroToN = '0..n';
}