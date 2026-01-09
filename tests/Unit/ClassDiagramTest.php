<?php

declare(strict_types=1);

use BeastBytes\Mermaid\InteractionType;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\ClassDiagram\ClassDiagram;
use BeastBytes\Mermaid\ClassDiagram\Classs;
use BeastBytes\Mermaid\ClassDiagram\Relationship;
use BeastBytes\Mermaid\ClassDiagram\RelationshipType;

defined('NAME') or define('NAME', 'Name');
defined('CLASS_NAMESPACE') or define('CLASS_NAMESPACE', 'Namespace');
defined('TITLE') or define('TITLE', 'Title');
defined('NOTE') or define('NOTE', 'Note');

test('Simple classDiagram', function () {
    $diagram = Mermaid::create(ClassDiagram::class)
        ->withClass(new Classs(NAME))
    ;

    expect($diagram->render())
        ->toBe(<<<EXPECTED
<pre class="mermaid">
classDiagram
  class Name {
  }
</pre>
EXPECTED
        )
    ;
});

test('classDiagram with namespaced class', function () {
    expect(Mermaid::create(ClassDiagram::class)
        ->withClass(new Classs(name: NAME, namespace:CLASS_NAMESPACE))
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
classDiagram
  namespace Namespace {
    class Name {
    }
  }
</pre>
EXPECTED
        )
    ;
});

test('classDiagram with note', function () {
    expect(Mermaid::create(ClassDiagram::class)
        ->withNote(NOTE)
        ->withClass(new Classs(NAME))
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
classDiagram
  note &quot;Note&quot;
  class Name {
  }
</pre>
EXPECTED
        )
    ;
});

test('classDiagram with title', function () {
    expect(Mermaid::create(ClassDiagram::class, ['title' => TITLE])
        ->withClass(new Classs(NAME))
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
---
title: Title
---
classDiagram
  class Name {
  }
</pre>
EXPECTED
        )
    ;
});

test('classDiagram with relationship', function (RelationshipType $relationship) {
    $rv = htmlspecialchars($relationship->value);

    expect(Mermaid::create(ClassDiagram::class)
        ->withClass(
            $class1 = new Classs(NAME . '1'),
            $class2 = new Classs(NAME . '2')
        )
        ->withRelationship(new Relationship($class1, $class2, $relationship))
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
classDiagram
  class Name1 {
  }
  class Name2 {
  }
  Name1 $rv Name2
</pre>
EXPECTED
        )
    ;
})
  ->with('relationshipType')
;

test('classDiagram with everything', function () {
    expect(Mermaid::create(ClassDiagram::class, ['title' => TITLE])
        ->withNote(NOTE)
        ->withClass(
            $class1 = (new Classs(name: NAME . '1', namespace: CLASS_NAMESPACE . '1'))
                ->withStyleClass('classDef0')
            ,
            $class2 = (new Classs(name: NAME . '2', namespace: CLASS_NAMESPACE . '1'))
                ->withStyleClass('classDef2')
                ->withNote('Class 2 note')
                ->withInteraction('https://example.com', InteractionType::link)
            ,
        )
        ->addClass(
            $class3 = (new Classs(name: NAME . '3', namespace: CLASS_NAMESPACE . '2'))
                ->withStyleClass('classDef1')
                ->withNote('Class 3 note')
                ->withInteraction('callback()', InteractionType::callback)
            ,
            $class4 = (new Classs(name: NAME . '4', namespace: CLASS_NAMESPACE . '2'))
                ->withInteraction('https://example.com', InteractionType::link)
        )
        ->withRelationship(
            new Relationship($class1, $class2, RelationshipType::inheritance),
            new Relationship($class2, $class3, RelationshipType::inheritance)
        )
        ->addRelationship(
            new Relationship($class2, $class4, RelationshipType::inheritance)
        )
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
---
title: Title
---
classDiagram
  note &quot;Note&quot;
  namespace Namespace1 {
    class Name1:::classDef0 {
    }
    class Name2:::classDef2 {
    }
  }
  note for Name2 &quot;Class 2 note&quot;
  click Name2 href &quot;https://example.com&quot; _self
  namespace Namespace2 {
    class Name3:::classDef1 {
    }
    class Name4 {
    }
  }
  note for Name3 &quot;Class 3 note&quot;
  click Name3 call callback()
  click Name4 href &quot;https://example.com&quot; _self
  Name1 --|&gt; Name2
  Name2 --|&gt; Name3
  Name2 --|&gt; Name4
</pre>
EXPECTED
        )
    ;
});

dataset('relationshipType', [
    RelationshipType::aggregation,
    RelationshipType::association,
    RelationshipType::composition,
    RelationshipType::dashedLink,
    RelationshipType::dependency,
    RelationshipType::inheritance,
    RelationshipType::realization,
    RelationshipType::solidLink,
]);