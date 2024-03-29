<?php

namespace App\Models;

/**
 * Class Allergen.
 */
class Allergen
{
    /**
     * ID of the allergen;
     *
     * @var integer|null
     */
    private $id;

    /**
     * Label of the allergen.
     *
     * @var string
     */
    private $label;

    /**
     * Constructor of the Allergen class.
     *
     * @param integer $id
     * @param string $label
     */
    public function __construct(int $id, string $label)
    {
        $this->id = $id;
        $this->label = ucfirst($label);
    }

    /**
     * Getter of the ID of the allergen.
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter of the label of the allergen.
     *
     * @return String
     */
    public function getLabel(): String
    {
        return $this->label;
    }

    /**
     * Setter of the label of the allergen.
     *
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label): self
    {
        $this->label = ucfirst($label);
        return $this;
    }
}