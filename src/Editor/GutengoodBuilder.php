<?php

declare(strict_types=1);

namespace Yarovikov\Gutengood\Editor;

class GutengoodBuilder
{
    protected array $components = [];
    protected array $repeater = [];
    protected array $section = [];

    protected function addComponent(string $name, string $type, array $args = []): self
    {
        $component = [
            'name' => $name,
            'type' => $type,
            ...$args,
        ];

        if (!empty($this->section)) {
            if (!empty($this->repeater)) {
                $this->repeater['fields'][] = $component;
            } else {
                $this->section['fields'][] = $component;
            }
        } else {
            $this->section = [
                'name' => __('Block Options'),
                'type' => 'Section',
                'open' => true,
            ];
            if (!empty($this->repeater)) {
                $this->repeater['fields'][] = $component;
            } else {
                $this->section['fields'][] = $component;
            }
        }

        return $this;
    }

    /**
     * TimePicker control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, bool is12hour, bool meta)
     *
     * @return self
     */
    public function addTimePicker(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'TimePicker', $args);
    }

    /**
     * File component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, bool meta)
     *
     * @return self
     */
    public function addFile(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'File', $args);
    }

    /**
     * Link component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string placeholder, bool use_title, bool meta)
     *
     * @return self
     */
    public function addLink(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Link', $args);
    }

    /**
     * Text control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, string value, string placeholder, bool meta)
     *
     * @return self
     */
    public function addText(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Text', $args);
    }

    /**
     * Textarea control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, string value, string placeholder, bool meta)
     *
     * @return self
     */
    public function addTextarea(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Textarea', $args);
    }

    /**
     * Toggle control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, bool value, bool meta)
     *
     * @return self
     */
    public function addToggle(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Toggle', $args);
    }

    /**
     * ColorPalette control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, array colors (string name, string color hex, string slug), string value, bool meta)
     *
     * @return self
     */
    public function addColorPalette(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'ColorPalette', $args);
    }

    /**
     * ColorPicker control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, bool alfa, bool meta)
     *
     * @return self
     */
    public function addColorPicker(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'ColorPicker', $args);
    }

    /**
     * Select control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, array choices (string label, string value), string value, bool meta)
     *
     * @return self
     */
    public function addSelect(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Select', $args);
    }

    /**
     * Message component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help)
     *
     * @return self
     */
    public function addMessage(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Message', $args);
    }

    /**
     * Image component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, int value, bool meta)
     *
     * @return self
     */
    public function addImage(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Image', $args);
    }

    /**
     * RichText component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, string placeholder, string value, bool meta)
     *
     * @return self
     */
    public function addRichText(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'RichText', $args);
    }

    /**
     * Range control component
     *
     * @param string $name The name of the component.
     * @param array $args (string label, string help, string placeholder, int step, int min, int max, int value, bool meta)
     *
     * @return self
     */
    public function addRange(string $name, array $args = []): self
    {
        return $this->addComponent($name, 'Range', $args);
    }

    /**
     * Repeater
     *
     * @param string $name The name of the repeater component.
     * @param array $args (string label, string help, string button_label, bool meta)
     *
     * @return self
     */
    public function addRepeater(string $name, array $args = []): self
    {
        $this->repeater = [
            'name' => $name,
            'type' => 'Repeater',
            'fields' => [],
            ...$args,
        ];

        return $this;
    }

    public function endRepeater(): self
    {
        $this->section['fields'][] = $this->repeater;
        $this->repeater = [];

        return $this;
    }

    /**
     * Section. Use this as accordion panel for options
     *
     * @param string $name The name of the section.
     * @param array $args (bool open)
     *
     * @return self
     */
    public function addSection(string $name, array $args = []): self
    {
        if (!empty($this->section)) {
            $this->components[] = $this->section;
        }

        $this->section = [
            'name' => $name,
            'type' => 'Section',
            'fields' => [],
            ...$args,
        ];

        return $this;
    }

    public function endSection(): self
    {
        if (!empty($this->section)) {
            $this->components[] = $this->section;
            $this->section = [];
        }

        return $this;
    }

    public function conditional(string $name, mixed $value): self
    {
        if (!empty($this->section)) {
            if (!empty($this->repeater)) {
                $index = count($this->repeater['fields']) - 1;
                if ($index >= 0) {
                    $this->repeater['fields'][$index]['condition'] = ['name' => $name, 'value' => $value];
                }
            } else {
                $index = count($this->section['fields']) - 1;
                if ($index >= 0) {
                    $this->section['fields'][$index]['condition'] = ['name' => $name, 'value' => $value];
                }
            }
        }

        return $this;
    }

    public function build(): array
    {
        if (!empty($this->section)) {
            $this->components[] = $this->section;
        }

        return $this->components;
    }
}
