<?php 
$base_url = Flight::get('base_url');
$objet = $objet ?? null;
$proprietaire = $proprietaire ?? null;
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $objet ? htmlspecialchars($objet['nom']) : 'Objet' ?> - Takalo</title>
    
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        body { padding-top: 80px; }
        .image-gallery img { cursor: pointer; transition: transform 0.2s; }
        .image-gallery img:hover { transform: scale(1.05); }
        .sticky-sidebar { position: sticky; top: 100px; }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-box-seam me-2 text-primary"></i>Takalo
            </a>
            <div class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/profile" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['user_nom']) ?>
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-primary btn-sm">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-fill"></i></a></li>
                <li class="breadcrumb-item"><a href="/objets">Objets</a></li>
                <li class="breadcrumb-item active"><?= $objet ? htmlspecialchars($objet['nom']) : 'Détail' ?></li>
            </ol>
        </nav>

        <?php if (!$objet): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Cet objet n'existe pas ou a été supprimé.
            </div>
        <?php else: ?>
            <div class="row">
                <!-- Galerie d'images -->
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-2">
                            <?php if (!empty($objet['images'])): ?>
                                <!-- Image principale -->
                                <div class="mb-3">
                                    <img id="mainImage" 
                                         src="/assets/images/<?= htmlspecialchars($objet['images'][0]['url']) ?>" 
                                         class="img-fluid rounded" 
                                         style="width: 100%; height: 400px; object-fit: cover;" 
                                         alt="<?= htmlspecialchars($objet['nom']) ?>">
                                </div>
                                
                                <!-- Miniatures -->
                                <?php if (count($objet['images']) > 1): ?>
                                    <div class="image-gallery d-flex gap-2 overflow-auto">
                                        <?php foreach ($objet['images'] as $image): ?>
                                            <img src="/assets/images/<?= htmlspecialchars($image['url']) ?>" 
                                                 class="rounded border" 
                                                 style="width: 80px; height: 80px; object-fit: cover;" 
                                                 onclick="document.getElementById('mainImage').src = this.src"
                                                 alt="Miniature">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="height: 400px;">
                                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Informations -->
                <div class="col-lg-5">
                    <div class="sticky-sidebar">
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><?= htmlspecialchars($objet['nom_categorie']) ?></span>
                                <h2 class="h4 mb-3"><?= htmlspecialchars($objet['nom']) ?></h2>
                                
                                <div class="d-flex align-items-center mb-3 text-muted">
                                    <i class="bi bi-person-circle me-2"></i>
                                    <span>Proposé par <strong><?= htmlspecialchars($objet['nom_membre'] ?? 'Inconnu') ?></strong></span>
                                </div>
                                
                                <div class="alert alert-success d-flex align-items-center">
                                    <i class="bi bi-tag-fill me-2 fs-4"></i>
                                    <div>
                                        <small class="d-block text-muted">Valeur estimée</small>
                                        <strong class="fs-4"><?= number_format($objet['prix_estimatif'], 2) ?> €</strong>
                                    </div>
                                </div>
                                
                                <h5 class="mb-2">Description</h5>
                                <p class="text-muted" style="white-space: pre-line;"><?= htmlspecialchars($objet['description']) ?></p>
                                
                                <hr>
                                
                                <div class="d-flex justify-content-between text-muted small mb-3">
                                    <span>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Publié le <?= date('d/m/Y', strtotime($objet['date_creation'])) ?>
                                    </span>
                                </div>
                                
                                <?php if (isset($_SESSION['user']) && $_SESSION['user_id'] != $objet['id_membre']): ?>
                                    <a href="/propositions/choisir-objet/<?= $objet['id'] ?>" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-arrow-left-right me-2"></i>Proposer un échange
                                    </a>
                                <?php elseif (!isset($_SESSION['user'])): ?>
                                    <a href="/login" class="btn btn-outline-primary btn-lg w-100">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Connectez-vous pour échanger
                                    </a>
                                <?php else: ?>
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Ceci est votre objet
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Carte du propriétaire -->
                        <?php if ($_SESSION['user_id'] != $objet['id_membre']): ?>
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h6 class="mb-3">À propos du propriétaire</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-person-fill text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <strong><?= htmlspecialchars($objet['nom_membre'] ?? 'Inconnu') ?></strong>
                                            <br>
                                            <small class="text-muted">Membre depuis <?= date('Y', strtotime($objet['date_inscription_membre'] ?? 'now')) ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>