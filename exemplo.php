<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        .quartoQt {
            border: 1px solid blue;
        }

        .quartoItem {
            border: 1px solid red;
        }

        .pnlMotor {
            width: 300px;
            border: 4px solid green;
            padding: 5px;
        }

        input[type="text"] {
            width: 100%;
        }

        .error {
            border: 2px solid red;
        }
    </style>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <?php do_shortcode("[infotravel_motor_assets]"); ?>

</head>
<body>

<?php do_shortcode("[infotravel_motor_hotel]"); ?>

<?php do_shortcode("[infotravel_motor_pacote_aereo]"); ?>

<?php do_shortcode("[infotravel_motor_pacote_dinamico]"); ?>

<?php do_shortcode("[infotravel_motor_pacote_rodo_hotel]"); ?>

<?php do_shortcode("[infotravel_motor_pacote_rodo_servico]"); ?>

</body>
</html>
