<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

enum Annotation: string
{
    case abstract = 'Abstract';
    case enum = 'Enumeration';
    case interface = 'Interface';
    case service = 'Service';
    case trait = 'Trait';
}