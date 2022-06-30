<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscreption</title>
    <link rel="stylesheet" href="<?= assets("css/seconnecter.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <nav>

    </nav>
    <form action="<?=route("inscription")?>" method="post">
        <h1>form d'inscription</h1>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom">
        <label for="ad">adresse</label>
        <input type="text" id="ad" name="adresse">
        <!-- <label for="prenom">Prenom</label> -->
        <!-- <input type="text" id="prenom" name="prenom"> -->
        <!-- <label for="an">Annee de naissance</label> -->
        <!-- <select name="annee_naiss" id="an">
        </select> -->
        <!-- <label for="email">Email</label>
        <input type="email" id="email" name="email">
        <label for="Mobile">Mobile</label>
        <input type="tel" id="mobile" name="mobile"> -->
        <label for="mp">mot de passe</label>
        <input type="password" id="mp" name="pass">
        <label for="cmp">confirmer le mot de passe</label>
        <input type="password" id="cmp" name="confirmer_pass">
        <button>s'inscrit</button>

        <a class="link" href="<?= route("/seconnecter") ?>">seconnecter</a>
    </form>

    <script>
        $(function() {
            //------------------------ SELECT ------------------------
            let select = $('select')
            for (let i = 1970; i <= (new Date).getFullYear(); i++) {
                let o = document.createElement('option')
                o.append(i)
                select.append(o)
            }


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