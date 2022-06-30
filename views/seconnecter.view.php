<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>se connecter</title>
    <link rel="stylesheet" href="<?= assets("css/seconnecter.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>
    <nav>

    </nav>
    <form action="<?=route("seconnecter")?>" method="post">
        <h1>form de connexion</h1>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom">
        <label for="mp">mot de passe</label>
        <input type="password" id="mp" name="pass">
        <button>se connecter</button>

        <a class="link" href="<?= route("/inscription") ?>">inscription</a>
    </form>

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