Method
======

.. php:class:: Method

  Represents a class method

  .. php:const:: IS_ABSTRACT

  .. php:const:: IS_STATIC

  .. php:method:: __construct(
      string $name,
      array $parameters = [],
      ?string $returnType = null,
      ?Visibility $visibility = null,
      bool $isAbstract = false,
      bool $isStatic = false
    )

    :param string $name: Method name
    :param array $parameters: Method parameters as either *name*=>*type* pairs and/or *name* items.
      *type* supports generics.
      .. note:: See `Generic Types <https://mermaid.js.org/syntax/classDiagram.html#generic-types>`__
      .. note:: Enter generics as normal, e.g. ``list<int>``
    :param ?string $returnType: Method return type (default: untyped)
    :param ?Visibility $visibility: Method :ref:`visibility <visibility>` (default: not explicitly specified)
    :param bool $isAbstract: Whether the method is abstract (default: false)
    :param bool $isStatic: Whether the method is static (default: false)
    :returns: An instance of Method
    :rtype: Method
