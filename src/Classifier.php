<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum Classifier: string
{
    case abstract = '*';
    case static = '$';
}