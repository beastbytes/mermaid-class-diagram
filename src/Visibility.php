<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum Visibility: string
{
    case public = '+';
    case private = '-';
    case protected = '#';
    case internal = '~';
}