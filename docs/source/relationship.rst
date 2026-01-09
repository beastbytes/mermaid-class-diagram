Relationship
============

.. php:class:: Relationship

  Represents a relationship between classes

  .. php:relationship:: __construct(
        Classs $classA,
        Classs $classB,
        RelationshipType $type,
        ?string $label = null,
        ?Cardinality $cardinalityA = null,
        ?Cardinality $cardinalityB = null
    )

    :param Classs $classA: A :doc:`class <classs>` in the relationship
    :param Classs $classB: A :doc:`class <classs>` in the relationship
    :param RelationshipType $type: The :ref:`relationship type <relationship-type>`
    :param ?string $label: Label for the relationship (default: no label)
    :param ?Cardinality $cardinalityA: The :ref:`cardinality <cardinality>` of class A
    :param ?Cardinality $cardinalityB: The :ref:`cardinality <cardinality>` of class B
    :returns: An instance of Relationship
    :rtype: Relationship