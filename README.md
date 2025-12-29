# Mermaid Class Diagram
PHP for [Mermaid.js](https://mermaid.js.org/) diagramming and charting tool [class diagram]().

For license information see the [LICENSE](LICENSE.md) file.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist beastbytes/mermaid-class-diagram
```

or add

```
"beastbytes/mermaid-class-diagram": "{{versionConstraint}}"
```

to the `require` section of your composer.json.

## API
### Attribute
Attribute represents an attribute in a class.

#### __construct()
Returns a new `Attribute` instance.
##### Parameters
| Name       | Type        | Description                                                                      | Default |
|------------|-------------|----------------------------------------------------------------------------------|---------|
| name       | string      | Name of the attribute                                                            |         |
| type       | ?string     | Attribute type e.g. string, int, ...<br/>If not given the attribute is not typed | null    |
| visibility | ?Visibility | Attribute visibility<br/>If not given the attribute visibility is not shown      | null    |
**Return Type:** Attribute

### ClassDiagram
ClassDiagram represents a class diagram.

#### addClass()
Returns a new instance of `ClassDiagram` with the given class(es) added to existing classes.
##### Parameters
| Name  | Type      | Description      |
|-------|-----------|------------------|
| class | ...Classs | Class(es) to add |
**Return Type:** ClassDiagram

#### addRelationship()
Returns a new instance of `ClassDiagram` with the given relationship(s) added to existing relationships.
##### Parameters
| Name         | Type         | Description            |
|--------------|--------------|------------------------|
| relationship | Relationship | Relationship(s) to add |
**Return Type:** ClassDiagram

#### withClass()
Returns a new instance of `ClassDiagram` with the given class(es).
##### Parameters
| Name  | Type   | Description      |
|-------|--------|------------------|
| class | Classs | Class(es) to set |
**Return Type:** ClassDiagram

#### withComment()
Returns a new instance of `ClassDiagram` with a comment.
##### Parameters
| Name    | Type   | Description |
|---------|--------|-------------|
| comment | string | The comment |
**Return Type:** ClassDiagram

#### withNote()
Returns a new instance of `ClassDiagram` with a note.
##### Parameters
| Name | Type   | Description |
|------|--------|-------------|
| note | string | The note    |
**Return Type:** ClassDiagram

#### withRelationship()
Returns a new instance of `ClassDiagram` with the given relationship(s).
##### Parameters
| Name         | Type         | Description            |
|--------------|--------------|------------------------|
| relationship | Relationship | Relationship(s) to set |
**Return Type:** ClassDiagram

### Classs
Classs represents a class in a class diagram.

#### __construct()
Returns a new `Classs` instance.
##### Parameters
| Name       | Type    | Description       | Default |
|------------|---------|-------------------|---------|
| name       | string  | Name of the class |         |
| annotation | ?string | Class annotation  | null    |
| label      | ?string | Class label       | null    |
| namespace  | ?string | Class namespace   | null    |
**Return Type:** Classs

#### addMember()
Returns a new instance of `Classs` with the given class member(s) added to existing class members.
##### Parameters
| Name   | Type                 | Description            |
|--------|----------------------|------------------------|
| member | ...Attribute\|Method | Class member(s) to add |
**Return Type:** Classs

#### withComment()
Returns a new instance of `Classs` with a comment.
##### Parameters
| Name    | Type   | Description |
|---------|--------|-------------|
| comment | string | The comment |
**Return Type:** Classs

#### withMember()
Returns a new instance of `Classs` with the given class member(s).
##### Parameters
| Name   | Type                 | Description     |
|--------|----------------------|-----------------|
| member | ...Attribute\|Method | Class member(s) |
**Return Type:** Classs

#### withNote()
Returns a new instance of `Classs` with a note.
##### Parameters
| Name | Type   | Description |
|------|--------|-------------|
| note | string | The note    |
**Return Type:** Classs

#### withStyleClass()
Returns a new instance of `Classs` with a note.
##### Parameters
| Name       | Type   | Description     |
|------------|--------|-----------------|
| styleClass | string | The style class |
**Return Type:** Classs

### Method
Method represents a method in a class.

#### __construct()
Returns a new `Method` instance.
##### Parameters
| Name       | Type        | Description                                                                                 | Default |
|------------|-------------|---------------------------------------------------------------------------------------------|---------|
| name       | string      | Name of the method                                                                          |         |
| parameters | array       | Method parameters                                                                           | []      |
| returnType | ?string     | Attribute type e.g. string, int, ...<br/>If not given the method's return type is not shown | null    |
| visibility | ?Visibility | Method visibility<br/>If not given the method visibility is not shown                       | null    |
**Return Type:** Method

### Relationship
Relationship represents a relationship between classes.

#### __construct()
Returns a new `Relationship` instance.
##### Parameters
| Name         | Type             | Description                               | Default |
|--------------|------------------|-------------------------------------------|---------|
| classA       | Classs           | A class that the relationship applies to  |         |
| classB       | Classs           | A class that the relationship applies to  |         |
| type         | RelationshipType | Relationship type                         |         |
| label        | ?string          | Label for the relationship                | null    |
| cardinalityA | ?Cardinality     | Cardinality of classA in the relationship | null    |
| cardinalityB | ?Cardinality     | Cardinality of classB in the relationship | null    |
**Return Type:** Relationship