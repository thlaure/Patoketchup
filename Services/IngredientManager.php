<?php

namespace App\Services;

use PDO;
use App\Interfaces\IRequirementManager;
use App\Models\Allergen;
use App\Models\Ingredient;
use App\Models\Recipe;

/**
 * Class IngredientManager implements IRequirementManager.
 */
class IngredientManager implements IRequirementManager
{
    /**
     * Insert an ingredient and a recipe in database.
     *
     * @param Ingredient $object
     * @param Recipe $recipe
     *
     * @return boolean
     */
    public static function insert($object, Recipe $recipe): bool
    {
        if (get_class($object) === "App\\Models\\Ingredient") {
            if (self::exists($object->getLabel())) {
                return false;
            }
            $stmt = PDOManager::getInstance()->getPDO()->prepare("INSERT INTO requirement(req_label, req_type) VALUES (:label, 'INGREDIENT');");
            $stmt->bindValue(":label", $object->getLabel(), PDO::PARAM_STR);
            $stmtReq = $stmt->execute();
            $stmt = PDOManager::getInstance()->getPDO()->prepare("INSERT INTO recipe_requirement(rr_fk_recipe_id, rr_fk_requirement_id, rr_quantity) VALUES (:recipeId, :requirementId, :quantity);");
            $stmt->bindValue(":recipeId", RecipeManager::findIdBy($recipe->getName()), PDO::PARAM_INT);
            $stmt->bindValue(":requirementId", self::findIdBy($object->getLabel()), PDO::PARAM_INT);
            $stmt->bindValue(":quantity", $object->getQuantity(), PDO::PARAM_STR);
            $stmtRR = $stmt->execute();
            return $stmtReq && $stmtRR;
        } else {
            return false;
        }
    }

    /**
     * Insert an ingredient in database associate to the allergen.
     *
     * @param Ingredient $object
     * @param Allergen $allergen
     *
     * @return boolean
     */
    public static function insertIngredient($object, Allergen $allergen = null): bool
    {
        if (get_class($object) === "App\\Models\\Ingredient") {
            if (self::exists($object->getLabel())) {
                return false;
            }
            $stmt = PDOManager::getInstance()->getPDO()->prepare("INSERT INTO requirement(req_label, req_type) VALUES (:label, 'INGREDIENT');");
            $stmt->bindValue(":label", $object->getLabel(), PDO::PARAM_STR);
            $stmtIngredient = $stmt->execute();
            if ($allergen) {
                $ingredient = self::findOneBy($object->getLabel());
                return $stmtIngredient && RequirementManager::insertRequirementAllergen($ingredient, $allergen);
            } else {
                return $stmtIngredient;
            }
        } else {
            return false;
        }
    }

    /**
     * Find the quantity of an ingredient in a recipe.
     *
     * @param Recipe $recipe
     * @param Ingredient $ingredient
     *
     * @return string
     */
    public static function findQuantityByRecipeAndRequirement(Recipe $recipe, Ingredient $ingredient): string
    {
        $stmt = PDOManager::getInstance()->getPDO()->prepare("SELECT * FROM recipe_requirement WHERE rr_fk_recipe_id = :recipeId AND rr_fk_requirement_id = :requirementId;");
        $stmt->bindValue(":recipeId", $recipe->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":requirementId", $ingredient->getId(), PDO::PARAM_INT);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result["rr_quantity"] : "0";
    }

    /**
     * Fetch all ingredients in database.
     *
     * @return array
     */
    public static function findAll(): array
    {
        $stmt = PDOManager::getInstance()->getPDO()->query("SELECT * FROM requirement WHERE req_type = 'INGREDIENT' ORDER BY req_label ASC;");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $objects = [];
        foreach ($results as $result) {
            array_push($objects, new Ingredient($result["req_id"], $result["req_label"], 0));
        }
        return $objects;
    }

    /**
     * Fetch an ingredient.
     *
     * @param void $identifier
     * @param bool $convertIntoObject
     *
     * @return null|Ingredient|array
     */
    public static function findOneBy($identifier, bool $convertIntoObject = true)
    {
        $stmt = PDOManager::getInstance()->getPDO()->prepare("SELECT * FROM requirement WHERE req_label = :label AND req_type = 'INGREDIENT';");
        $stmt->bindValue(":label", $identifier, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$convertIntoObject) {
            return $result;
        }
        return $result ? new Ingredient($result["req_id"], $result["req_label"], 0) : null;
    }

    /**
     * Fetch the ID of the ingredient.
     *
     * @param void $identifier
     *
     * @return integer|null
     */
    public static function findIdBy($identifier): ?int
    {
        $stmt = PDOManager::getInstance()->getPDO()->prepare("SELECT req_id FROM requirement WHERE req_label = :label AND req_type = 'INGREDIENT';");
        $stmt->bindValue(":label", $identifier, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result["req_id"] : null;
    }

    /**
     * Verify if the ingredient exists.
     *
     * @param void $identifier
     *
     * @return boolean
     */
    public static function exists($identifier): bool
    {
        return self::findOneBy($identifier) ? true : false;
    }

    /**
     * Fetch all ingredients by recipe.
     *
     * @param Recipe $recipe
     *
     * @return array
     */
    public static function findAllByRecipe(Recipe $recipe): array
    {
        $stmt = PDOManager::getInstance()->getPDO()->prepare("SELECT * FROM requirement INNER JOIN recipe_requirement ON requirement.req_id = recipe_requirement.rr_fk_requirement_id WHERE rr_fk_recipe_id = :recipeId AND req_type = 'INGREDIENT';");
        $stmt->bindValue(":recipeId", RecipeManager::findIdBy($recipe->getName()), PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $objects = [];
        foreach ($results as $result) {
            array_push($objects, new Ingredient($result["req_id"], $result["req_label"], $result["rr_quantity"]));
        }
        return $objects;
    }

    /**
     * Remove an ingredient from database.
     *
     * @param int $identifier
     */
    public static function deleteOneById($identifier): bool
    {
        $stmt = PDOManager::getInstance()->getPDO()->prepare("DELETE FROM requirement WHERE req_id = :id;");
        $stmt->bindValue(":id", $identifier, PDO::PARAM_INT);
        return $stmt->execute();
    }
}