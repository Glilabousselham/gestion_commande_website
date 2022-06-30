<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>panier</title>
    <link rel="stylesheet" href="<?= assets("css/panier.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <!-- header -->
    <?php include "includes/nav.inc.php" ?>


    <section>
        <h1>confirmation de mon commandes</h1>
        <?php if (isset($articles)) : ?>
            <h3>Panier (<span class="number"></span>)</h3>

            <ul class="list-produit">

                <?php foreach ($articles as $article) : ?>
                    <li>
                        <div class="produit-card" id="<?= $article['num_article'] ?>">
                            <div class="produit-header">
                                <img src="<?= storage($article['img_article']) ?>" alt="">
                                <div class="title">
                                    <?= $article['lib_article'] ?>
                                </div>
                                <div class="prix">
                                    <span><?= $article['prix_article'] ?></span> DH
                                </div>
                            </div>
                            <div class="produit-footer">
                                <div class="supprimer">
                                    <button>supprimer</button>
                                </div>
                                <div class="quantite">
                                    <input type="hidden" value="<?= $article['qte_stock_article'] ?>">
                                    <button class="moins">-</button>
                                    <div class="qte">3</div>
                                    <button class="plus">+</button>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="confermation">
                <div>
                    Total
                    <span>988</span>
                    dh
                </div>
                <input type="hidden" value="<?= route("api/confirmer_commande") ?>">
                <button>Confirmer</button>
            </div>
        <?php else : ?>
            <p>le panier est vide !!!!</p>
        <?php endif; ?>
    </section>


    <script>
        $(function() {


            let articles = JSON.parse(sessionStorage.getItem('articles')) ?? []
            let totale = sessionStorage.getItem('totale') ?? 0
            totale = 0
            if (articles.length) {
                articles.forEach(article => {
                    totale += article.qte
                    $("#" + article.id + " .quantite .qte").html(article.qte);

                    // supprimer
                    $("#" + article.id + " .supprimer button").click(function() {
                        //
                        $("#" + article.id).parent().remove() // remove li html
                        removeArticle(article.id) // remove article from session

                    })
                    // plus
                    $("#" + article.id + " .quantite .plus").click(function() {
                        //get max qte
                        max = +$(this).prev().prev().prev().val()
                        // get qte ele
                        qte_el = $(this).prev()

                        if (+qte_el.html() < max) {
                            new_qte = +qte_el.html() + 1
                            qte_el.html(new_qte)

                            add_article(article.id, new_qte)
                        }

                        update_prix_totale()
                    })
                    // moins
                    $("#" + article.id + " .quantite .moins").click(function() {
                        console.log("-");
                        //get max qte
                        max = +$(this).prev().val()

                        // get qte ele
                        qte_el = $(this).next()

                        if (+qte_el.html() > 1) {
                            new_qte = +qte_el.html() - 1
                            qte_el.html(new_qte)

                            add_article(article.id, new_qte)
                        }
                        update_prix_totale()
                    })

                });
            }
            sessionStorage.setItem("totale", totale)
            $(".panier-counter").html(sessionStorage.getItem('totale').toString())

            $('.confermation button').click(confirmer)

            update_prix_totale()
        })

        function update_prix_totale() {
            let totale_prix = 0
            let articles = JSON.parse(sessionStorage.getItem('articles')) ?? []
            if (articles.length) {
                articles.forEach(article => {
                    totale_prix += $("#" + article.id + " .prix span").html() * article.qte
                });
            }
            $(".confermation div span").html(totale_prix);
        }

        function confirmer() {
            // console.log("confirmer");
            url = $(".confermation input").val()
            articles = JSON.parse(sessionStorage.getItem('articles'));
            data = {}
            for (let i = 0; i < articles.length; i++) {
                const a = articles[i];

                data["id" + a.id] = a.qte

            }




            $.post(url, data)
                .done(function(data) {
                    // console.log(data);
                    if (data.success) {
                        sessionStorage.removeItem('articles');
                        show_alert(data.data, data.redirect)

                    } else {
                        if (data.redirect) {
                            window.location = data.redirect
                        }
                    }
                })
                .fail(function(err) {
                    console.log(err);
                    console.log("fail");
                })
                .always(function() {
                    // console.log("alwas");
                });
        }






















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

            // console.log(articles);
        }

        function removeArticle(article_id) {
            let articles = JSON.parse(sessionStorage.getItem('articles')) ?? []

            if (articles.length) {
                // console.log(articles);
                for (let i = 0; i < articles.length; i++) {
                    const article = articles[i];

                    if (article.id == article_id) {
                        articles.splice(i, 1);
                        break;
                    }
                }
                sessionStorage.setItem('articles', JSON.stringify(articles));

                url = $(".panier").attr('href');
                if (articles.length) {
                    params = '?articles='
                    articles.forEach(function(a) {
                        params += a.id + ","
                    })
                    params = params.slice(0, -1)
                    window.location = url + params
                } else {
                    window.location = url
                }
            }
        }

        function show_alert(articles, to) {
            alert = document.createElement('div')
            alert.classList.add("alert")

            title = document.createElement('div')
            title.classList.add("alert_title")
            title.append("Commande reussie!!")

            table = document.createElement('table')

            tr = document.createElement('tr')

            th1 = document.createElement('th')
            th1.append("Libelle")
            th2 = document.createElement('th')
            th2.append("quantite")
            th3 = document.createElement('th')
            th3.append("prix unitare")

            tr.appendChild(th1)
            tr.appendChild(th2)
            tr.appendChild(th3)

            table.appendChild(tr)



            alert.appendChild(title)
            alert.appendChild(table)

            prix_totale = document.createElement('div')
            prix_totale.classList.add('alert_prix_totale')

            alert.appendChild(prix_totale)

            btn = document.createElement('button')

            btn.append('ok')

            alert.appendChild(btn)

            btn.onclick = (e) => {
                e.target.parentElement.remove()
                // action
                window.location = to
            }

            // lkhdma
            totale = 0
            articles.forEach(a => {
                totale += a.prix * a.qte
                td1 = document.createElement('td')
                td1.append(a.libelle)
                td2 = document.createElement('td')
                td2.append(a.qte)
                td3 = document.createElement('td')
                td3.append(a.prix + " DH")
                tr = document.createElement('tr')
                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                table.appendChild(tr)
            });
            prix_totale.append("Prix totale: " + totale + " DH")


            document.body.appendChild(alert)
            // section style
            $("section,nav").css({
                opacity:'.2'
            })

            client_with = window.innerWidth;
            alert_with = alert.offsetWidth;

            left = (client_with - alert_with) / 2

            alert.style.left = left + "px";
        }
    </script>

</body>

</html>