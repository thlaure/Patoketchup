<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <?php include __DIR__ . "/templates/head.php"; ?>
</head>

<body class="position-relative min-vh-100 bg-light">
    <?php if (isset($_SESSION["member"])) {
        include __DIR__ . "/templates/header_member.php";
    } else {
        include __DIR__ . "/templates/header_client.php";
    } ?>

    <div class="container">
        <section class="mt-5">
            <h1 class="text-center"><?php echo $recipe->getName(); ?></h1>
            <h4 class="text-center mt-3 font-weight-lighter">
                <?php
                echo ucwords(strtolower($recipe->getType()));
                foreach ($recipe->getTags() as $tag) {
                    echo "<span class='badge badge-pill badge-dark mx-1'>" . $tag->getLabel() . "</span>";
                }
                ?>
            </h4>
            <div class="lead text-center mt-5">
                <p class="d-inline mx-5"><i class="fas fa-stopwatch"></i> <?php echo $recipe->getTime(); ?> min</p>
                <p class="d-inline mx-5"><i class="fas fa-users"></i> <?php echo $recipe->getNbPersons(); ?> personne.s</p>
                <p class="d-inline mx-5">Difficulté
                    <?php
                    $difficulty = $recipe->getDifficulty();
                    $difference = 5 - $difficulty;
                    for ($i = 0; $i < $difficulty; $i++) {
                        echo "<span><i class='fas fa-circle'></i></span>";
                    }
                    for ($i = 0; $i < $difference; $i++) {
                        echo "<span><i class='far fa-circle'></i></span>";
                    }
                    ?>
                </p>
            </div>
            <div class="lead text-center mt-5" id="button-action">
                <?php
                if (isset($inArray) && $inArray === true) { ?>
                    <button class="btn btn-dark" id="button-delete-favorite" title="DeleteFavorite" value="<?php echo $recipe->getId(); ?>"><i class="fas fa-star text-warning"></i> Supprimer des favoris</button>
                    <button class="btn btn-dark" id="button-add-favorite" title="AddFavorite" value="<?php echo $recipe->getId(); ?>" hidden><i class="far fa-star"></i> Ajouter aux favoris</button>
                <?php } else { ?>
                    <button class="btn btn-dark" id="button-delete-favorite" title="DeleteFavorite" value="<?php echo $recipe->getId(); ?>" hidden><i class="fas fa-star text-warning"></i> Supprimer des favoris</button>
                    <button class="btn btn-dark" id="button-add-favorite" title="AddFavorite" value="<?php echo $recipe->getId(); ?>"><i class="far fa-star"></i> Ajouter aux favoris</button>
                <?php } ?>
            </div>
            <div class="col mx-auto mt-5">
                <p class="lead text-justify"><?php echo $recipe->getDescription(); ?></p>
            </div>
            <div class="text-center">
                <img src="https://thomaslaure.alwaysdata.net/Shlagithon/assets/images/<?php echo $recipe->getImage(); ?>" class="img-fluid rounded img-detail" alt="image">
            </div>
            <div class="row mx-auto mt-5 border border-dark rounded p-3">
                <article class="col-md-4">
                    <h5><i class="fas fa-utensils"></i> Ustensiles</h5>
                    <ul>
                        <?php foreach ($ustencils as $ustencil) {
                            echo "<li>" . $ustencil->getQuantity() . " " . strtolower($ustencil->getLabel()) . "</li>";
                        } ?>
                    </ul>
                </article>
                <article class="col-md-4">
                    <h5><i class="fas fa-carrot"></i> Ingrédients</h5>
                    <ul>
                        <?php foreach ($ingredients as $ingredient) {
                            echo "<li>" . $ingredient->getQuantity() . " " . strtolower($ingredient->getLabel()) . "</li>";
                        } ?>
                    </ul>
                </article>
                <article class="col-md-4">
                    <h5><i class="fas fa-info"></i> À propos de cette recette</h5>
                    <ul>
                        <?php foreach ($allergens as $allergen) {
                            echo "<li>" . $allergen->getLabel() . "</li>";
                        } ?>
                    </ul>
                </article>
            </div>
            <article class="col-md-12 my-5">
                <h5><i class="fas fa-ellipsis-v"></i> Etapes</h5>
                <ol>
                    <?php foreach ($recipe->getSteps() as $step) {
                        echo "<li>" . $step->getDescription() . "</li>";
                    } ?>
                </ol>
            </article>
            <?php if ($recipe->getAdvice()) { ?>
                <div class="col-md-6 m-auto">
                    <p class="text-justify"><i class="far fa-lightbulb"></i> <?php echo $recipe->getAdvice(); ?></p>
                </div>
            <?php } ?>
            <div class="row mx-auto mt-5">
                <div class="col-md-12">
                    <h4 class="text-center"><i class="far fa-comment-dots"></i> Commentaires</h4>
                    <div class="container">
                        <?php if (!empty($commentaries)) { ?>
                            <?php foreach ($commentaries as $commentary) { ?>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong><?php echo $commentary->getAuthor()->getFirstname() . " " . $commentary->getAuthor()->getName(); ?></strong>, <span class="text-muted">le <?php echo date_format(date_create($commentary->getWritingDate()), "d/m/Y"); ?> à <?php echo date_format(date_create($commentary->getWritingDate()), "H\hi"); ?></span>
                                            </div>
                                            <div class="panel-body">
                                                <?php echo $commentary->getText(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if (isset($_SESSION["member"])) { ?>
                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <form action="" method="POST">
                                                <div class="form-group">
                                                    <label for="comment">Laisser un commentaire</label>
                                                    <textarea name="comment" class="form-control" rows="3"></textarea>
                                                </div>
                                                <button type="submit" name="validate" id="validate" class="btn btn-dark mt-2 float-right">Poster</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include __DIR__ . "/templates/footer.php"; ?>
    <?php include __DIR__ . "/templates/scriptsjs.php"; ?>
    <script src="https://thomaslaure.alwaysdata.net/Shlagithon/assets/js/ajax/ajax_favorite_recipe.js"></script>
</body>

</html>