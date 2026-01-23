Usage
=====

Class diagrams define the attributes and methods of classes, and the relationships between them;
each of these are represented by objects.

Classes are created and attributes and methods added to them;
the classes are then added to a *ClassDiagram* object, together with the relationships between them.
Both *Classs* and the *ClassDiagram* objects can be further configured, e.g. styles, comments, etc.

Finally, the *ClassDiagram* object is rendered to generate the Mermaid code.

Example
-------

PHP
+++

.. code-block:: php
    $class1 = (new Classs(name: 'Class1', namespace: 'App\Example'))
        ->withAttribute(
            new Attribute('id', 'string', Visibility::private),
            new Attribute('name', 'string', Visibility::private),
        )
        ->withMethod(
            new Method('getId', returnType: 'string', visibility: Visibility::public),
            new Method('getName', returnType: 'string', visibility: Visibility::public),
            new Method('setName', ['name => 'string'], returnType: 'self', visibility: Visibility::public)
        )
        ->withStyleClass('style0')
    ;
    $class2 = (new Classs(name: 'Class2', namespace: 'App\Example'))
        ->withAttribute(
            new Attribute('id', 'string', Visibility::private),
            new Attribute('class1Id', 'string', Visibility::private),
        )
        ->withMethod(
            new Method('getId', returnType: 'string', visibility: Visibility::public),
            new Method('getClass1', returnType: 'Class1', visibility: Visibility::public),
            new Method('setClass1', ['class1 => 'Class1'], returnType: 'self', visibility: Visibility::public)
        )
        ->withStyleClass('style2')
        ->withNote('Class 2 note')
        ->withInteraction('https://example.com', InteractionType::Link)
    ;

    Mermaid::create(ClassDiagram::class, ['title' => 'Diagram Title'])
        ->withNote('Diagram Note')
        ->withClass($class1, $class2)
        ->withRelationship(
            new Relationship($class1, $class2, RelationshipType::inheritance)
        )
        ->render()
    ;
  
Generated Mermaid
+++++++++++++++++
  
.. code-block:: html

    <pre class="mermaid">
    ---
    title: Title
    ---
    classDiagram
      note "Note"
      namespace Namespace1 {
        class Name1:::classDef0 {
        }
        class Name2:::classDef2 {
        }
      }
      note for Name2 "Class 2 note"
      click Name2 href "https://example.com" _self
      namespace Namespace2 {
        class Name3:::classDef1 {
        }
        class Name4 {
        }
      }
      note for Name3 "Class 3 note"
      click Name3 call callback()
      click Name4 href "https://example.com" _self
      Name1 --|> Name2
      Name2 --|> Name3
      Name2 --|> Name4
</pre>

Mermaid Diagram
+++++++++++++++

.. mermaid::

    ---
    title: Title
    ---
    classDiagram
      note "Note"
      namespace Namespace1 {
        class Name1:::classDef0 {
        }
        class Name2:::classDef2 {
        }
      }
      note for Name2 "Class 2 note"
      click Name2 href "https://example.com" _self
      namespace Namespace2 {
        class Name3:::classDef1 {
        }
        class Name4 {
        }
      }
      note for Name3 "Class 3 note"
      click Name3 call callback()
      click Name4 href "https://example.com" _self
      Name1 --|> Name2
      Name2 --|> Name3
      Name2 --|> Name4