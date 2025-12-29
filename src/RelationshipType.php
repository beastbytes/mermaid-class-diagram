<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum RelationshipType: string
{
    case aggregation = '--o';
    case association = '-->';
    case composition = '--*';
    case dashedLink = '..';
    case dependency = '..>';
    case inheritance = '--|>';
    case realization = '..|>';
    case solidLink = '--';
}