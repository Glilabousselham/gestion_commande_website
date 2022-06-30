<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestion des articles</title>
    <link rel="stylesheet" href="<?= assets("css/getsion_articles.css") ?>">
    <link rel="stylesheet" href="<?= assets("css/style.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <nav>
        <ul>

            <li><a onclick="return false">gestion des articles</a></li>
            <li><a href="<?= route("admin_panel") ?>">Routeur a panneau d'administration</a></li>

        </ul>
    </nav>


    <section>
        <br>
        <br>
        <br>
        <?php if (isset($_SESSION["success"])) : ?>
            <?php if ($_SESSION["success"]) : ?>
                <center>
                    <div class="success">l'article est supprimer </div>
                </center>
            <?php else : ?>
                <center>
                    <div class="error">l'article n'est pas supprimer </div>
                </center>
            <?php endif; ?>
            <?php unset($_SESSION['success']) ?>
        <?php endif; ?>

        <table>
            <tr>
                <th class="td_img">image</th>
                <th class="td_lib">libelle</th>
                <th class="td_prix">prix (DH)</th>
                <th class="td_qte">quanttite</th>
                <th class="td_actions">actions</th>
            </tr>


            <?php  ?>


            <?php if (isset($articles) && $articles) : ?>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td class="td_img"><img src="<?= storage($article['img_article'])  ?>" alt=""></td>
                        <td class="td_lib"><?= $article['lib_article']  ?></td>
                        <td class="td_prix"><?= $article['prix_article']  ?></td>
                        <td class="td_qte"><?= $article['qte_stock_article']  ?></td>
                        <td class="td_actions">
                            <button class="supprimer"><a href="<?= route("supprimer_article?id=" . $article['num_article']) ?>">supprimer</a></button>
                            <!-- <button class="modifier" id="<?php /*$article['num_article'] */ ?>">modifier</button> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">
                        <p>no articles</p>
                    </td>
                </tr>
            <?php endif; ?>


        </table>
    </section>
</body>

</html>