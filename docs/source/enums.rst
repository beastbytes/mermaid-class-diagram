Enums
=====

.. _annotation:
.. php:enum:: Annotation : string

  Class annotation

  .. php:case:: abstract : 'Abstract'
  .. php:case:: enum : 'Enumeration'
  .. php:case:: interface : 'Interface'
  .. php:case:: service : 'Service'
  .. php:case:: trait : 'Trait'

.. _cardinality:
.. php:enum:: Cardinality : string

  Class cardinality in a relationship 

  .. php:case:: many : '*'
  .. php:case:: n : 'n'
  .. php:case:: oneOrMore : '1..*'
  .. php:case:: oneToN : '1..n'
  .. php:case:: only1 : '1'
  .. php:case:: zeroOrOne : '0..1'
  .. php:case:: zeroToN : '0..n'

.. _relationship-type:
.. php:enum:: RelationshipType : string

  Type of relationship

  .. php:case:: aggregation : '--o'
  .. php:case:: association : '-->'
  .. php:case:: composition : '--*'
  .. php:case:: dashedLink : '..'
  .. php:case:: dependency : '..>'
  .. php:case:: inheritance : '--|>'
  .. php:case:: realization : '..|>'
  .. php:case:: solidLink : '--'

.. _visibility:
.. php:enum:: Visibility : string

  Attribute and method visibility

  .. php:case:: public : '+'
  .. php:case:: private : '-'
  .. php:case:: protected : '#'
  .. php:case:: internal : '~'
