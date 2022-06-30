<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestion commandes</title>
    <link rel="stylesheet" href="<?= assets('css/gestion_commandes.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
    <script src="<?= assets('js/jquery.js') ?>"></script>
    <script src="<?= assets('js/bootstrap.min.js') ?>"></script>
</head>

<body>

    <nav class="admin-nav">
        <a href="<?= route("admin_panel") ?>">Panneau d'administrateur</a>
    </nav>

    <div class="container">
        <br>
        <h1>Gestion des commandes</h1>
        <br>
        <?php if (isset($_SESSION['success'])) : ?>
            <?php if ($_SESSION['success']) : ?>
                <div class="success">La commande est supprimer!</div>
            <?php else : ?>
                <div class="success">La commande n'est pas supprimer!</div>
            <?php endif; ?>
            <?php unset($_SESSION['success']) ?>
        <?php endif; ?>
        <table class="table table-borderless">


            <?php if ($commandes && count($commandes)) : ?>
                <tr class="border border-2 border-top-0 border-start-0 border-end-0">
                    <th>ID</th>
                    <th>client</th>
                    <th>date</th>
                    <th></th>
                </tr>
                <?php $i = 1 ?>
                <?php foreach ($commandes as $commande) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $commande['nom_client'] ?></td>
                        <td><?= $commande['date_commande'] ?></td>
                        <td class="text text-end">
                            <a href="<?= route("supprimer_commande?id=" . $commande['num_commande']) ?>" class="btn btn-danger p-1">supprimer</a>
                            <a href="<?= route("about_commande?id=" . $commande['num_commande']) ?>" class="btn btn-warning p-1">more</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text text-center">No commandes</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>

</html>