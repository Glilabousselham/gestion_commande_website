<?php

use App\Http\Auth;
?>
<nav>
    <ul>
        <li class="logo"><a href="<?= route("/") ?>">logo</a></li>
        <li><a href="<?= route("/") ?>">acueil</a></li>
        <li><a href="<?= route("/admin_panel") ?>">admin</a></li>

        <?php if (Auth::client()) : ?>
            <li><a href="<?= route("/deconnecter") ?>">Deconnexion</a></li>
        <?php else : ?>
            <li><a href="<?= route("/seconnecter") ?>">Se Connecter</a></li>
        <?php endif; ?>

        <li><a href="<?= route("/panier") ?>" class="panier"><img class="icon" src="<?= assets("icons/panier.png") ?>" alt=""><span class="panier-counter">0</span>Panier</a></li>
    </ul>

    <div class="search-bar">
        <form action="<?= route('/') ?>">
            <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>" class="search-input">
            <button class="search-btn">search</button>
        </form>
    </div>
</nav>

<style>

</style>

<script>
    // panier click
    $(".panier").click(panier)

    function panier(event) {
        event.preventDefault()

        url = $(this).attr('href');
        // console.log(url);
        articles = JSON.parse(sessionStorage.getItem('articles'))

        if (articles.length) {
            params = '?articles='

            articles.forEach(function(a) {
                params += a.id + ","
            })
            params = params.slice(0, -1)


            // console.log(params);
            window.location = url + params
        } else {
            window.location = url

        }

    }
</script>