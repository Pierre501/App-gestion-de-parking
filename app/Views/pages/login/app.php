<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("images/favicon.png"); ?>">
    <link href="<?= base_url("css/style.min.css"); ?>" rel="stylesheet">
    <link href="<?= base_url("css/main.css"); ?>" rel="stylesheet">
</head>

<body>
    <section class="vh-100 bg-dark">
        <div class="container py-5 w-75 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-6">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">

                        <?= $this->renderSection('content-login') ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url("js/jquery.min.js") ?>"></script>
    <script src="<?= base_url("js/bootstrap.min.js"); ?>"></script>
    <script src="<?= base_url("js/login.js") ?>"></script>
</body>

</html>