Classs
======

.. php:class:: Classs

  Represents a class in the ClassDiagram.

  Once created, attributes and methods are added to the class.
  Regardless of the order they are added, attributes and methods are rendered in the following order:
  * by visibility: *public*, *protected*, *private*, *internal*.
    If a an attribute or method's visibility is not specified it is considered *public*.
  * then by classifier - for attributes: *static*, *others* - for methods: *abstract static*, *abstract*, *static*, *others*
  * then by name

  .. php:method::  __construct(
    string $name,
    Annotation|string|null $annotation = null,
    ?string $label = null,
    ?string $namespace = null,
    ?string $type = null
  )

    :param string $name: Class name
    :param string Annotation|string|null $annotation: Class annotation
    :param string ?string $label: A label for the class (default: no label)
    :param ?string $namespace: Class namespace (default: no namespace)
    :param ?string $type: Class type. Generics are are supported (default: untyped)
      .. note:: See `Generic Types <https://mermaid.js.org/syntax/classDiagram.html#generic-types>`__
      .. note:: Enter generics as normal, e.g. list<int>
    :returns: An instance of Classs
    :rtype: Classs

  .. php:method:: addAttribute(Attribute ...$attribute)

    Add attribute(s)

    :param Attribute ...$attribute: The attribute(s)
    :returns: A new instance of ``Classs`` with the attributes added
    :rtype: Classs

  .. php:method:: addMethod(Method ...$method)

    Add method(s)

    :param Method ...$method: The method(s)
    :returns: A new instance of ``Classs`` with the methods added
    :rtype: Classs
  
  .. php:method:: withAttribute(Attribute ...$attribute)

    Set attribute(s)

    :param Attribute ...$attribute: The attribute(s)
    :returns: A new instance of ``Classs`` with the attributes
    :rtype: Classs

  .. php:method:: withComment(string $comment)

    Add a comment

    :param string $comment: The comment
    :returns: A new instance of ``Classs` with the comment
    :rtype: Classs

  .. php:method:: withInteraction(
    string $interaction,
    InteractionType $type,
    string $tooltip = '',
    InteractionTarget $target = InteractionTarget::Self,
  )

    Add an interaction

    :param string $interaction:
    :param InteractionType $type:
    :param string $tooltip:
    :param InteractionTarget $target:
    :returns: A new instance of ``Classs`` with
    :rtype: Classs

  .. php:method:: withMethod(Method ...$method)

    Set methods(s)

    :param Method ...$method: The method(s)
    :returns: A new instance of ``Classs`` with the methods
    :rtype: Classs

  .. php:method:: withNote(string $note)

    Add a note

    :param string $note: The note
    :returns: A new instance of ``Classs`` with the note
    :rtype: Classs