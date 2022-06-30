<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin login</title>
    <link rel="stylesheet" href="<?= assets('css/admin_change_pass.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
    <script src="<?= assets('js/jquery.js') ?>"></script>
</head>

<body>

    <nav>
        <a href="<?= route('/admin_panel') ?>">Annuler</a>
    </nav>

    <form action="<?= route("admin_change_pass") ?>" method="POST">

        <h1>changement de mot de passe</h1>

        <label for="">Ancien mo de passe</label>
        <input type="password" name="old_pass">
        <label for="">Nouveau mot de pass</label>
        <input type="password" name="pass">
        <label for="">confirmer le mot de pass</label>
        <input type="password" name="confirmer_pass">
        <button>changer</button>

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
                errors = $('.text_error') ?? false
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
                if ($("input[name=pass]").val() !== $("input[name=confirmer_pass]").val()) {
                    valid = false
                    $("input[name=confirmer_pass]").addClass('border_red')
                }
                return valid
            })


        })

        function createSpanError() {
            span = document.createElement('span')
            span.append('svp remplir ce champ')
            span.classList.add('text_error')
            return span;
        }
    </script>
</body>

</html>