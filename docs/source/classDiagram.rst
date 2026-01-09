ClassDiagram
============

.. php:class:: ClassDiagram

  Represents a Class Diagram.

  .. php:method:: addClass(Classs ...$class)

    Add class(es)

    :param Classs ...$class: The class(es) to add
    :returns: A new instance of ``ClassDiagram`` with the class(es) added
    :rtype: ClassDiagram

  .. php:method:: addRelationship(Relationship ...$relationship)

     Add relationship(s) between classes

    :param Relationship ...$relationship: The relationship(s) to add
    :returns: A new instance of ``ClassDiagram`` with the relationship(s) added
    :rtype: ClassDiagram

  .. php:method:: render(array $attributes = [])

    Renders a Mermaid chart or diagram

    :param array $attributes: HTML attributes for the <pre> tag as name=>value pairs
    .. note:: The `mermaid` class is added
    :returns: Mermaid class diagram code in a <pre> tag
    :rtype: string

  .. php:method:: withClass(Classs ...$class)

    Set the class(es)

    :param Classs ...$class: The class(es) to set
    :returns: A new instance of ``ClassDiagram`` with the class(es)
    :rtype: ClassDiagram

  .. php:method:: withComment(string $comment)

    Add a comment to the diagram

    :param string $comment: The comment
    :returns: A new instance of ``ClassDiagram`` with the comment
    :rtype: ClassDiagram

  .. php:method:: withNote(string $note)

    Add a note to the diagram

    :param string $note: The note
    :returns: A new instance of ``ClassDiagram`` with the note
    :rtype: ClassDiagram

  .. php:method:: withRelationship(Relationship ...$relationship)

    Set relationship(s) between classes

    :param Relationship ...$relationship: The relationship(s) to add
    :returns: A new instance of ``ClassDiagram`` with the relationship(s)
    :rtype: ClassDiagram