<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="<?= assets("css/index.css") ?>">
    <link rel="stylesheet" href="<?= assets("css/style.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <!-- header -->
    <?php include "includes/nav_search.inc.php" ?>


    <section>
        <!-- <h1>no produit </h1> -->

        <?php if (isset($articles) && count($articles)) : ?>
            <?php foreach ($articles as $article) : ?>
                <?php if ($article['qte_stock_article'] != 0) : ?>
                    <div class="produit-card" id="<?= $article['num_article'] ?>">
                        <input type="hidden" value="<?= $article['qte_stock_article'] ?>">
                        <img src="<?= storage($article['img_article']) ?>" alt="#" class="produit-img">
                        <div class="produit-title"><?= $article['lib_article'] ?></div>
                        <div class="produit-prix"><?= $article['prix_article'] ?> dh</div>
                        <button class="produit-btn">achat</button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-produit-available">
                il n'y a pas d'articles pour le moment!
            </div>
        <?php endif; ?>
    </section>

    <footer>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
        <div>pas d'information hhh</div>
    </footer>
    <script>
        // console.log(JSON.parse(sessionStorage.getItem('articles')));
        // return


        function add_article(article_id, qte) {
            articles = JSON.parse(sessionStorage.getItem('articles')) ?? []
            updated = false
            // totale article
            totale = 0
            for (let i = 0; i < articles.length; i++) {
                if (articles[i].id == article_id) {
                    articles[i].qte = qte;
                    updated = true
                }
                totale += +articles[i].qte
            }
            if (!updated) {
                articles.push({
                    id: article_id,
                    qte: qte
                })
                totale++
            }

            sessionStorage.setItem('articles', JSON.stringify(articles))
            sessionStorage.setItem('totale', totale)
            $('.panier-counter').html(totale.toString())

        }

        $(document).ready(function() {

            // if commends en cours
            articles = JSON.parse(sessionStorage.getItem('articles')) ?? []

            totale = 0
            // update the html
            articles.forEach(c => {
                $("#" + c.id + " .produit-btn").remove()
                $("#" + c.id).append(createControle(c.id, c.qte))
                totale += c.qte
            });

            sessionStorage.setItem("totale", totale)
            $(".panier-counter").html(sessionStorage.getItem('totale').toString())



            // achat click
            $(".produit-btn").click(achat)


        })

        // /////////////////////    //////////////////// //




        function achat(event) {
            article_id = $(this).parent().attr('id')
            article_card = $(this).parent()

            // create controlle
            controlle = createControle(article_id, 1)

            $(this).remove()
            article_card.append(controlle)
            // add article
            add_article(article_id, 1)

        }

        function createControle(article_id, qte = 1) {
            // create 
            div = document.createElement('div')
            div.classList.add("control")
            me = document.createElement('button')
            me.append("-")

            pe = document.createElement('button')
            pe.append("+")

            qe = document.createElement('div')
            qe.append(qte)
            max = +$("#" + article_id + " input").val()
            // actions
            me.onclick = (event) => {
                let q = event.target.nextElementSibling
                v = +q.innerHTML
                if (v < 2) {
                    return
                }
                v--
                q.innerHTML = v
                add_article(article_id, v)
            }
            pe.onclick = (event) => {

                let q = event.target.previousElementSibling
                v = +q.innerHTML

                if (v == max) {
                    return
                }

                v++
                q.innerHTML = v
                add_article(article_id, v)
            }


            // append
            div.appendChild(me)
            div.appendChild(qe)
            div.appendChild(pe)

            return div;

        }
    </script>
</body>

</html>