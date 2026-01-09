<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\ClassDiagram;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\IdTrait;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\StyleClassTrait;

final class Classs
{
    use CommentTrait;
    use IdTrait;
    use InteractionTrait;
    use RenderItemsTrait;
    use StyleClassTrait;

    public const string DEFAULT_NAMESPACE = '';
    private const string ANNOTATION = '<<%s>>';
    private const string LABEL = '["%s"]';
    private const string NOTE = 'note for %s "%s"';
    private const string TYPE = 'class';

    /** @psalm-var Attribute[] */
    private array $attributes = [];
    /** @psalm-var Method[] */
    private array $methods = [];
    private ?string $note = null;

    public function __construct(
        string $name,
        private readonly Annotation|string|null $annotation = null,
        private readonly ?string $label = null,
        private readonly ?string $namespace = null,
        private readonly ?string $type = null,
    )
    {
        $this->id = $name;
    }

    /** @internal */
    public function getNamespace(): string
    {
        return is_string($this->namespace) ? $this->namespace : self::DEFAULT_NAMESPACE;
    }

    public function addAttribute(Attribute ...$attribute): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $attribute);
        return $new;
    }

    public function addMethod(Method ...$method): self
    {
        $new = clone $this;
        $new->methods = array_merge($new->methods, $method);
        return $new;
    }

    public function withAttribute(Attribute ...$attribute): self
    {
        $new = clone $this;
        $new->attributes = $attribute;
        return $new;
    }

    public function withMethod(Method ...$method): self
    {
        $new = clone $this;
        $new->methods = $method;
        return $new;
    }

    public function withNote(string $note): self
    {
        $new = clone $this;
        $new->note = $note;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $this->renderComment($indentation);
        $output[] = $indentation
            . self::TYPE
            . ' '
            . $this->getId()
            . (is_string($this->label) ? sprintf(self::LABEL, $this->label) : '')
            . (is_string($this->type) ? str_replace(['<', '>'], '~', $this->type) : '')
            . $this->getStyleClass()
            . ' {';
        $output[] = is_string($this->annotation)
            ? $indentation . Mermaid::INDENTATION . sprintf(self::ANNOTATION, $this->annotation)
            : ''
        ;
        $output[] = $this->renderMembers($this->attributes, $indentation);
        $output[] = $this->renderMembers($this->methods, $indentation);
        $output[] = $indentation . '}';

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }

    /** @internal */
    public function renderNote(string $indentation): ?string
    {
        return is_string($this->note) ? $indentation . sprintf(self::NOTE, $this->getId(), $this->note) : null;
    }

    /**
     * @param Member[] $members
     * @param string $indentation
     * @return string
     */
    private function renderMembers(array $members, string $indentation): string
    {
        // sort the members by visibility - public, protected, private, internal
        // within each visibility sort by classifier - abstract static, abstract, static, none
        // within each classifier sort by name
        usort($members, function (Member $a, Member $b) {
            $u = match ($a->getVisibility()) {
                Visibility::public => match($b->getVisibility()) {
                    Visibility::public => 0,
                    Visibility::protected, Visibility::private, Visibility::internal => -1
                },
                Visibility::protected => match($b->getVisibility()) {
                    Visibility::public => 1,
                    Visibility::protected => 0,
                    Visibility::private, Visibility::internal => -1
                },
                Visibility::private => match($b->getVisibility()) {
                    Visibility::public, Visibility::protected => 1,
                    Visibility::private => 0,
                    Visibility::internal => -1
                },
                Visibility::internal => match($b->getVisibility()) {
                    Visibility::public, Visibility::protected, Visibility::private => 1,
                    Visibility::internal => 0
                }
            };

            if ($u === 0) {
                $abstractA = $a->isAbstract();
                $abstractB = $b->isAbstract();
                $staticA = $a->isStatic();
                $staticB = $b->isStatic();

                if ($abstractA) {
                    if ($staticA) {
                        if (!$abstractB || !$staticB) {
                            $u = -1;
                        }
                    } elseif (!$abstractB) {
                        $u = -1;
                    } elseif ($staticB) {
                        $u = 1;
                    }
                } elseif ($staticA) {
                    if ($abstractB) {
                        $u = 1;
                    } elseif (!$staticB) {
                        $u = -1;
                    }
                } else if ($abstractB || $staticB) {
                    $u = 1;
                }
            }

            if ($u === 0) {
                $u = $a->getName() <=> $b->getName();
            }

            return $u;
        });

        return $this->renderItems($members, $indentation);
    }
}