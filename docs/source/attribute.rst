Attribute
=========

.. php:class:: Attribute

  Represents a class attribute

  .. php:const:: IS_STATIC

  .. php:method:: __construct(
      string $name,
      ?string $type = null,
      ?Visibility $visibility = null,
      bool $isStatic = false
    )

    :param string $name: Attribute name
    :param ?string $type: Attribute type. Generics are supported (default: untyped)
      .. note:: See `Generic Types <https://mermaid.js.org/syntax/classDiagram.html#generic-types>`__
      .. note:: Enter generics as normal, e.g. list<int>
    :param ?Visibility $visibility: Attribute visibility
    :param bool $isStatic: Whether the attribute is static (default: false)
    :returns: An instance of Attribute
    :rtype: Attribute