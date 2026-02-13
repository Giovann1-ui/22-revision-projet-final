<?php 
$base_url = Flight::get('base_url');
$objet = $objet ?? null;
$historique = $historique ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique - <?= $objet ? htmlspecialchars($objet['nom']) : 'Objet' ?> - Takalo</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { padding-top: 80px; background-color: #f8f9fa; }
        .timeline { position: relative; padding: 20px 0; }
        .timeline-item { position: relative; padding-left: 60px; padding-bottom: 30px; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 30px;
            bottom: -10px;
            width: 2px;
            background: #dee2e6;
        }
        .timeline-item:last-child::before { display: none; }
        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #6366f1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body>

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
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-fill"></i></a></li>
                <li class="breadcrumb-item"><a href="/objets/<?= $objet['id'] ?>"><?= htmlspecialchars($objet['nom']) ?></a></li>
                <li class="breadcrumb-item active">Historique</li>
            </ol>
        </nav>

        <?php if (!$objet): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Cet objet n'existe pas ou a été supprimé.
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="h4 mb-3">
                                <i class="bi bi-clock-history me-2 text-primary"></i>
                                Historique d'appartenance
                            </h2>
                            <p class="text-muted">Objet : <strong><?= htmlspecialchars($objet['nom']) ?></strong></p>
                        </div>
                    </div>

                    <?php if (empty($historique)): ?>
                        <div class="card shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <h5 class="mt-3">Aucun échange historique</h5>
                                <p class="text-muted">Cet objet n'a pas encore été échangé.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="timeline">
                                    <?php foreach ($historique as $index => $echange): ?>
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </div>
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <h6 class="mb-0">Échange #<?= $echange['id'] ?></h6>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar3 me-1"></i>
                                                            <?= date('d/m/Y à H:i', strtotime($echange['date_proposition'])) ?>
                                                        </small>
                                                    </div>
                                                    
                                                    <div class="row g-3">
                                                        <div class="col-md-5">
                                                            <div class="bg-light rounded p-3">
                                                                <small class="text-muted d-block mb-1">Proposé par</small>
                                                                <p class="mb-1 fw-bold">
                                                                    <i class="bi bi-person me-1"></i>
                                                                    <?= htmlspecialchars($echange['nom_membre1']) ?>
                                                                </p>
                                                                <p class="mb-0 text-primary">
                                                                    <i class="bi bi-box me-1"></i>
                                                                    <?= htmlspecialchars($echange['nom_objet_membre1']) ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-arrow-left-right text-primary fs-3"></i>
                                                        </div>
                                                        
                                                        <div class="col-md-5">
                                                            <div class="bg-light rounded p-3">
                                                                <small class="text-muted d-block mb-1">Accepté par</small>
                                                                <p class="mb-1 fw-bold">
                                                                    <i class="bi bi-person me-1"></i>
                                                                    <?= htmlspecialchars($echange['nom_membre2']) ?>
                                                                </p>
                                                                <p class="mb-0 text-success">
                                                                    <i class="bi bi-box me-1"></i>
                                                                    <?= htmlspecialchars($echange['nom_objet_membre2']) ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>