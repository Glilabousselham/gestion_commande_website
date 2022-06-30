<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajouter article</title>
    <link rel="stylesheet" href="<?= assets("css/ajouter_article.css") ?>">
    <link rel="stylesheet" href="<?= assets("css/style.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <nav>
        <ul>

            <li><a onclick="return false">panneau d'administration</a></li>
            <li><a href="<?= route('admin_panel') ?>">annuler</a></li>

        </ul>
    </nav>

    <section>
        <?php if (isset($_SESSION["success"])) : ?>
            <br>
            <br>
            <?php if ($_SESSION["success"]) : ?>
                <center>
                    <div class="success">l'article a ajoute </div>
                </center>
            <?php else : ?>
                <center>
                    <div class="error">l'article n'a pas ajoute </div>
                </center>
            <?php endif; ?>
            <?php unset($_SESSION['success']) ?>
        <?php endif; ?>

        
        <form action="<?= route("ajouter_article") ?>" method="post" enctype="multipart/form-data">
            <h1>Ajouter un article</h1>
            <label for="">libelle de l'article</label>
            <input type="text" name="libelle">
            <label for="">la quantite en stocke</label>
            <input type="number" name="qte">
            <label for="">le prix en (DH)</label>
            <input type="number" name="prix">
            <label for="">image de l'article</label>
            <input type="file" name="img">
            <button>ajouter</button>
        </form>

    </section>


    <script>
        $(function() {
            //------------------------ SELECT ------------------------
            // let select = $('select')
            // for (let i = 1970; i <= (new Date).getFullYear(); i++) {
            //     let o = document.createElement('option')
            //     o.append(i)
            //     select.append(o)
            // }


            //-------------------- form submitting --------------------
            let form = $('form')

            form.submit(function(event) {
                // remove spans error if exists
                errors = $('.error') ?? false
                if (errors) {
                    errors.remove()
                }

                // remove error style from the inputs
                $('input').removeClass('border_red')


                let inputs = $('form input');
                let valid = true;
                inputs.each(function(index) {
                    let input = $(this)

                    if (input.val().toString().trim() == '') {

                        input.addClass('border_red')

                        error = createSpanError()
                        input.after(error)

                        valid = false
                    }
                })
                return valid
            })




        })

        function createSpanError() {
            span = document.createElement('span')
            span.append('svp remplir ce champ')
            span.classList.add('error')
            return span;
        }
    </script>
</body>

</html>