<?php

use app\models\UserModel;
use Flight;

$error = $error ?? '';
$base_url = Flight::get('base_url');

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <title>Connexion - Metis</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    <link rel="icon" type="image/png" href="<?= $base_url ?>assets/favicon-B_cwPWBd.png">

    <link rel="stylesheet" href="<?= $base_url ?>css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= $base_url ?>bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="<?= $base_url ?>assets/main-QD_VOj1Y.css">

    <link rel="stylesheet" href="<?= $base_url ?>css/style.css">

    <style>
        .card-header.bg-primary {
            background-color: white !important;
            color: black !important;
            border-bottom: 1px solid #dee2e6;
            text-align: left !important;
            padding: 1.5rem 1.5rem !important;
        }

        .card-header.bg-primary h4 {
            text-align: left;
            margin-bottom: 0;
        }

        .card-header.bg-primary h4 i {
            color: #198754 !important;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary">
                        <h4><i class="bi bi-box-arrow-in-right"></i> Connexion</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="/login" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="nom" class="form-control" placeholder="Entrez votre nom"
                                        required value="pierre_durand">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="motDePasse" class="form-control"
                                        placeholder="Entrez votre mot de passe" required value="password123">
                                </div>
                            </div>

                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Se connecter
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="/register">Pas de compte ? S'inscrire</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="module" src="<?= $base_url ?>assets/vendor-bootstrap-C9iorZI5.js"></script>

</body>


</html>