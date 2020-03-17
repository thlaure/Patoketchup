<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Tag;
use App\Models\Requirement;

/**
 * Class Recipe.
 */
class Recipe
{
    /**
     * ID of the recipe
     *
     * @var integer
     */
    private $id;

    /**
     * Name of the recipe.
     *
     * @var string
     */
    private $name;

    /**
     * Description of the recipe.
     *
     * @var string
     */
    private $description;

    /**
     * Image of the recipe.
     *
     * @var string
     */
    private $image;

    /**
     * Difficulty of the recipe.
     *
     * @var integer
     */
    private $difficulty;

    /**
     * Time to make the recipe in minutes.
     *
     * @var integer
     */
    private $time;

    /**
     * Number of persons of the recipe.
     *
     * @var integer
     */
    private $nbPersons;

    /**
     * Advice of the recipe.
     *
     * @var string
     */
    private $advice;

    /**
     * Tags of the recipe.
     *
     * @var array
     */
    private $tags;

    /**
     * Ustencils of the recipe.
     *
     * @var array
     */
    private $ustencils;

    /**
     * Ingredients of the recipe.
     *
     * @var array
     */
    private $ingredients;

    /**
     * Member who writes the recipe.
     *
     * @var Member
     */
    private $author;

    /**
     * Steps of the recipe.
     *
     * @var
     */
    private $steps;

    /**
     * Constructor of the Recipe class.
     *
     * @param string $name
     * @param string $description
     * @param string $image
     * @param integer $difficulty
     * @param integer $time
     * @param integer $nbPersons
     * @param Member $author
     * @param string|null $advice
     */
    public function __construct(string $name, string $description, string $image, int $difficulty, int $time, int $nbPersons, Member $author, string $advice = null)
    {
        $this->name = ucfirst($name);
        $this->description = $description;
        $this->image = $image;
        $this->difficulty = $difficulty;
        $this->time = $time;
        $this->nbPersons = $nbPersons;
        $this->advice = $advice;
        $this->tags = [];
        $this->ustencils = [];
        $this->ingredients = [];
        $this->author = $author;
        $this->steps = [];
    }

    /**
     * Getter of the ID of the recipe.
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter of the name of the recipe.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Setter of the name of the recipe/
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = ucfirst($name);
        return $this;
    }

    /**
     * Getter of the description of the recipe.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Setter of the description of the recipe.
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gette of the image of the recipe.
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Setter of the image of the recipe.
     *
     * @param string $image
     *
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Getter of the difficulty of the recipe.
     *
     * @return integer
     */
    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    /**
     * Setter of the difficulty of the recipe.
     *
     * @param integer $difficulty
     *
     * @return self
     */
    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;
        return $this;
    }

    /**
     * Getter of the time of the recipe.
     *
     * @return integer
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * Setter of the time of the recipe.
     *
     * @param integer $time
     *
     * @return self
     */
    public function setTime(int $time): self
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Getter of the number of persons of the recipe.
     *
     * @return integer
     */
    public function getNbPersons(): int
    {
        return $this->nbPersons;
    }

    /**
     * Setter of the number of persons of the recipe.
     *
     * @param integer $nbPersons
     *
     * @return self
     */
    public function setNbPersons(int $nbPersons): self
    {
        $this->nbPersons = $nbPersons;
        return $this;
    }

    /**
     * Getter of the advice of the recipe.
     *
     * @return string|null
     */
    public function getAdvice(): ?string
    {
        return $this->advice;
    }

    /**
     * Setter of the advice of the recipe.
     *
     * @param string $advice
     *
     * @return self
     */
    public function setAdvice(string $advice): self
    {
        $this->advice = $advice;
        return $this;
    }

    /**
     * Getter of the tags of the recipe.
     *
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Setter of the tags of the recipe.
     *
     * @param array $tags
     *
     * @return $this
     */
    public function setTags(array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Add a tag to the recipe.
     *
     * @param Tag $tag
     *
     * @return array
     */
    public function addTag(Tag $tag): array
    {
        array_push($this->tags, $tag);
        return $this->tags;
    }

    /**
     * Remove a tag from the recipe.
     *
     * @param Tag $tag
     *
     * @return array
     */
    public function removeTag(Tag $tag): array
    {
        if (in_array($tag, $this->tags)) {
            unset($tag);
            return array_values($this->tags);
        } else {
            return $this->tags;
        }
    }

    /**
     * Getter of the ustencils of the recipe.
     *
     * @return array
     */
    public function getUstencils(): array
    {
        return $this->ustencils;
    }

    /**
     * Setter of the ustencils of the recipe.
     *
     * @param array $ustencils
     *
     * @return $this
     */
    public function setUstencils(array $ustencils): self
    {
        $this->ustencils = $ustencils;
        return $this;
    }

    /**
     * Add a ustencil to the recipe.
     *
     * @param Ustencil $ustencil
     *
     * @return array
     */
    public function addUstencil(Ustencil $ustencil): array
    {
        array_push($this->ustencils, $ustencil);
        return $this->ustencils;
    }

    /**
     * Remove a ustencil from the recipe.
     *
     * @param Ustencil $ustencil
     *
     * @return array
     */
    public function removeUstencil(Ustencil $ustencil): array
    {
        if (in_array($ustencil, $this->ustencils)) {
            unset($ustencil);
            return array_values($this->ustencils);
        } else {
            return $this->ustencils;
        }
    }

    /**
     * Getter of the ingredients of the recipe.
     *
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * Setter of the ingredients of the recipe.
     *
     * @param array $ingredients
     *
     * @return $this
     */
    public function setIngredients(array $ingredients): self
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * Add a ingredient to the recipe.
     *
     * @param Ingredient $ingredient
     *
     * @return array
     */
    public function addIngredient(Ingredient $ingredient): array
    {
        array_push($this->ingredients, $ingredient);
        return $this->ingredients;
    }

    /**
     * Remove a ingredient from the recipe.
     *
     * @param Ingredient $ingredient
     *
     * @return array
     */
    public function removeIngredient(Ingredient $ingredient): array
    {
        if (in_array($ingredient, $this->ingredients)) {
            unset($ingredient);
            return array_values($this->ingredients);
        } else {
            return $this->ingredients;
        }
    }

    /**
     * Getter of the author of the recipe.
     *
     * @return Member
     */
    public function getAuthor(): Member
    {
        return $this->author;
    }

    /**
     * Setter of the author of the recipe.
     *
     * @param Member $author
     *
     * @return self
     */
    public function setAuthor(Member $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Getter of the steps of the recipe.
     *
     * @return array
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    /**
     * Setter of the steps of the recipe.
     *
     * @param array $steps
     *
     * @return $this
     */
    public function setSteps(array $steps): self
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * Add a step to the recipe.
     *
     * @param Step $step
     *
     * @return array
     */
    public function addStep(Step $step): array
    {
        array_push($this->steps, $step);
        return $this->steps;
    }

    /**
     * Remove a step from the recipe.
     *
     * @param Step $step
     *
     * @return array
     */
    public function removeStep(Step $step): array
    {
        if (in_array($step, $this->steps)) {
            unset($step);
            return array_values($this->steps);
        } else {
            return $this->steps;
        }
    }
}