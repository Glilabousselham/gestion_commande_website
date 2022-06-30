<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="<?= assets("css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= assets("css/admin_panel.css") ?>">
    <link rel="stylesheet" href="<?= assets("css/style.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <nav class="admin-nav text-end">
        <a href="<?= route("admin_logout") ?>">deconnexion</a>
    </nav>


    <h1>admin control</h1>


    <br>
    <?php if (isset($_SESSION['success'])) : ?>
        <?php if ($_SESSION['success']) : ?>
            <div class="success">the database was reseted successfully!</div>
            <?php else : ?>
                <div class="success">the database was not reseted!</div>
        <?php endif; ?>
        <?php unset($_SESSION['success']) ?>
    <?php endif; ?>

    <section>
        <a class="link" href="<?= route("ajouter_article") ?>">Ajouter un nouveau article</a>
        <a class="link" href="<?= route("gestion_articles") ?>">Gestion des articles</a>
        <a class="link" href="<?= route("gestion_commandes") ?>">Gestion des commandes</a>
        <a class="link" href="<?= route("admin_change_pass") ?>">Change le mot de pass</a>
        <a class="link" id="reset_db" href="<?= route("reset_db") ?>">Reset the database</a>
        <!-- <a class="action" href="">voirs tout les clients</a> -->
    </section>
    <script>
        $('#reset_db').click(function(event) {
            event.preventDefault();
            var r = confirm('do you want to reset the data base ?');
            if (r == true) {
                window.location = $(this).attr('href');
            }

        });
    </script>
</body>


</html>