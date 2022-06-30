<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin login</title>

    <link rel="stylesheet" href="<?= assets("css/admin_login.css") ?>">
    <link rel="stylesheet" href="<?= assets("css/style.css") ?>">
    <script src="<?= assets("js/jquery.js") ?>"></script>
</head>

<body>

    <nav>
        <a href="<?= route('/') ?>">accueil</a>
    </nav>

    <?php if (isset($_SESSION['success'])) : ?>
        <?php if ($_SESSION['success']) : ?>
            <div class="success"></div>
        <?php else : ?>
            <div class="error">les informations que vous avez saisies sont incorrectes</div>
        <?php endif; ?>
        <?php unset($_SESSION['success']) ?>
    <?php endif; ?>



    <form action="<?= route("admin_login") ?>" method="post">

        <h1>admin</h1>

        <label for="">username</label>
        <input type="text" name="username">
        <label for="">mot de pass</label>
        <input type="password" name="password">
        <button>connexion</button>

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