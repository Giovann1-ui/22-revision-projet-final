<?php 
$base_url = Flight::get('base_url');
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Takalo</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    
    <!-- Bootstrap CSS local -->
    <link rel="stylesheet" href="<?= $base_url ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        /* Éviter que le navbar cache le contenu */
        body {
            padding-top: 80px !important;
        }
        
        .admin-header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 1030 !important;
        }
        
        .admin-header .navbar {
            margin-bottom: 0 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
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
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="d-flex align-items-center gap-3">
                            <a href="/profile"><span class="text-muted">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($_SESSION['user_nom']) ?>
                            </span></a>
                            <a href="/mes-objets" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box me-1"></i>Mes objets
                            </a>
                            <a href="/logout" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                            </a>
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
                <h2 class="mb-3">Objets disponibles pour l'échange</h2>
                <p class="text-muted">Découvrez les objets proposés par les autres membres</p>
            </div>
        </div>

        <!-- Liste des objets -->
        <div class="row g-4">
            <?php if (empty($objets)): ?>
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3">Aucun objet disponible</h5>
                            <p class="text-muted">
                                <?php if (isset($_SESSION['user'])): ?>
                                    Les autres membres n'ont pas encore ajouté d'objets
                                <?php else: ?>
                                    Connectez-vous pour voir les objets disponibles
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($objets as $objet): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-primary"><?= htmlspecialchars($objet['nom_categorie']) ?></span>
                                    <small class="text-muted">
                                        <i class="bi bi-person me-1"></i>
                                        <?= htmlspecialchars($objet['nom_membre']) ?>
                                    </small>
                                </div>
                                
                                <h5 class="card-title"><?= htmlspecialchars($objet['nom']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars(substr($objet['description'], 0, 100)) ?>...</p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-success fw-bold">
                                        <i class="bi bi-tag me-1"></i>
                                        <?= number_format($objet['prix_estimatif'], 2) ?> €
                                    </span>
                                    <a href="/objets/<?= $objet['id'] ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>Voir
                                    </a>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    Ajouté le <?= date('d/m/Y', strtotime($objet['date_creation'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Bouton pour voir ses propres objets -->
        <?php if (isset($_SESSION['user'])): ?>
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="/mes-objets" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-seam me-2"></i>Gérer mes objets
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- Bootstrap Bundle JS local -->
    <script src="<?= $base_url ?>css/bootstrap.bundle.min.js" nonce="<?= Flight::get('csp_nonce') ?>"></script>
    
    <script nonce="<?= Flight::get('csp_nonce') ?>">
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les dropdowns Bootstrap
            var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
</body>
</html>