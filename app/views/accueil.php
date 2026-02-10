<?php 
$base_url = Flight::get('base_url');
$user = $user ?? null;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Takalo</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/main-QD_VOj1Y.css">
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23logoGradient)'/%3e%3cpath%20d='M10%2024V8h2.5l2.5%206.5L17.5%208H20v16h-2V12.5L16.5%2020h-1L14%2012.5V24H10z'%20fill='white'%20font-weight='700'/%3e%3cdefs%3e%3clinearGradient%20id='logoGradient'%20x1='0'%20y1='0'%20x2='32'%20y2='32'%3e%3cstop%20offset='0%25'%20stop-color='%236366f1'/%3e%3cstop%20offset='100%25'%20stop-color='%238b5cf6'/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e"
                        alt="Logo" height="32" class="d-inline-block align-text-top me-2">
                    <h1 class="h4 mb-0 fw-bold text-primary">Takalo</h1>
                </a>

                <div class="navbar-nav ms-auto">
                    <?php if ($user): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <span><?= htmlspecialchars($user['username']) ?></span>
                                <i class="bi bi-chevron-down ms-1"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profil</a></li>
                                <li><a class="dropdown-item" href="/mes-objets"><i class="bi bi-box me-2"></i>Mes objets</a></li>
                                <li><a class="dropdown-item" href="/messages"><i class="bi bi-chat-dots me-2"></i>Messages</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-3">Bienvenue sur Takalo</h2>
                <p class="text-muted">Plateforme d'échange d'objets entre particuliers</p>
            </div>
        </div>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Erreur :</strong> <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                Connecté en tant que <strong><?= htmlspecialchars($_SESSION['user_nom']) ?></strong> (ID: <?= $_SESSION['user_id'] ?>)
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Aucun utilisateur connecté. Veuillez vérifier la configuration de la base de données.
            </div>
        <?php endif; ?>

        <!-- Liste des objets -->
        <div class="row g-4">
            <?php if (empty($objets)): ?>
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3">Aucun objet disponible</h5>
                            <p class="text-muted">Les objets d'échange apparaîtront ici</p>
                            <?php if ($user): ?>
                                <a href="/mes-objets/ajouter" class="btn btn-primary mt-3">
                                    <i class="bi bi-plus-lg me-2"></i>Ajouter un objet
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($objets as $objet): ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($objet['image_url'] ?? 'placeholder.jpg') ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($objet['nom']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($objet['nom']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($objet['description']) ?></p>
                                <p class="text-muted">
                                    <i class="bi bi-tag me-1"></i>
                                    Prix estimatif: <?= number_format($objet['prix_estimatif'], 2) ?> €
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="/objets/<?= $objet['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <script src="<?= $base_url ?>assets/vendor-bootstrap-C9iorZI5.js"></script>
    <script src="<?= $base_url ?>assets/vendor-ui-CflGdlft.js"></script>
</body>
</html>