<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <?php include __DIR__ . "/../templates/head.php"; ?>
</head>

<body class="position-relative min-vh-100 bg-light">
    <?php include __DIR__ . "/../templates/header_member.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Liste des demandes</h1>
        <div class="col-md-6">
            <form action="?" method="POST">
                <label for="select-filter">Trier par : </label>
                <div class="row">
                    <div class="col-md-8">
                        <select name="select-filter" id="select-filter" class="form-control rounded">
                            <option value="closed">Demandes fermées</option>
                            <option value="open">Demandes ouvertes</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="text-center btn btn-dark" name="filter" title="Filtrer">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mt-5 table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Autheur</th>
                        <th scope="col">Sujet</th>
                        <th scope="col">Date de création</th>
                        <th scope="col">Date de dernière modification</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket) { ?>
                        <tr>
                            <td><?php echo $ticket->getAuthor()->getName() . " " . $ticket->getAuthor()->getFirstname(); ?></td>
                            <td><?php echo $ticket->getSubject(); ?></td>
                            <td><?php echo $ticket->getWritingDate(); ?></td>
                            <td><?php echo $ticket->getLastUpdateDate(); ?></td>
                            <td class="border-top-0 d-inline-block">
                                <div class="ml-1 d-inline">
                                    <a href="consult-ticket?ticket-id=<?php echo $ticket->getId(); ?>" class="table-link" title="Consultation"><i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include __DIR__ . "/../templates/footer.php"; ?>
    <?php include __DIR__ . "/../templates/scriptsjs.php"; ?>
</body>

</html>