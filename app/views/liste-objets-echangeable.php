<?php 
$base_url = Flight::get('base_url');
$mes_objets = $mes_objets ?? [];
$objet_demande = $objet_demande ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir un objet - Takalo</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        body { padding-top: 80px; background-color: #f8f9fa; }
        
        /* Style des cartes radio */
        .objet-selector {
            position: relative;
            cursor: pointer;
        }

        /* On cache le bouton radio réel mais on le garde accessible */
        .objet-selector input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .objet-card {
            transition: all 0.2s ease;
            border: 2px solid transparent;
            z-index: 1;
        }

        /* Quand le radio est coché, on change le style de la carte parente */
        .objet-selector input[type="radio"]:checked + .objet-card {
            border-color: #10b981;
            background-color: #ecfdf5;
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Affichage de l'icône de validation uniquement si coché */
        .selection-check {
            display: none;
            color: #10b981;
            font-size: 1.5rem;
        }
        .objet-selector input[type="radio"]:checked + .objet-card .selection-check {
            display: block;
        }

        .comparison-header {
            background: #6366f1;
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="bi bi-box-seam me-2 text-primary"></i>Takalo</a>
        </div>
    </nav>

    <main class="container my-5">
        
        <?php if ($objet_demande): ?>
        <div class="comparison-header text-center">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="p-3 bg-white text-dark rounded shadow-sm">
                        <small class="text-muted text-uppercase fw-bold">Objet souhaité</small>
                        <h4 class="mt-2"><?= htmlspecialchars($objet_demande['nom']) ?></h4>
                        <span class="badge bg-primary"><?= number_format($objet_demande['prix_estimatif'], 2) ?> €</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <i class="bi bi-arrow-left-right display-6"></i>
                </div>
                <div class="col-md-5">
                    <div class="p-3 border border-dashed rounded text-white-50">
                        <p class="mb-0">Sélectionnez un objet <br>dans la liste ci-dessous</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <form method="POST" action="/propositions/creer">
            <input type="hidden" name="id_objet_demande" value="<?= $objet_demande['id'] ?? '' ?>">
            <input type="hidden" name="id_membre_receveur" value="<?= $objet_demande['id_membre'] ?>">
            <?= $objet_demande['id_membre'] ?>

            <div class="row g-4">
                <?php foreach ($mes_objets as $objet): ?>
                    <div class="col-md-4">
                        <label class="objet-selector w-100 h-100">
                            <input type="radio" name="id_objet_propose" value="<?= $objet['id'] ?>" required>
                            
                            <div class="card objet-card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-0">
                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($objet['nom_categorie']) ?></span>
                                    <i class="bi bi-check-circle-fill selection-check"></i>
                                </div>
                                
                                <?php if (!empty($objet['images'])): ?>
                                    <img src="/assets/images/<?= htmlspecialchars($objet['images'][0]['url']) ?>" 
                                         class="card-img-top" style="height: 180px; object-fit: cover;">
                                <?php endif; ?>

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($objet['nom']) ?></h5>
                                    <p class="text-success fw-bold mb-0"><?= number_format($objet['prix_estimatif'], 2) ?> €</p>
                                </div>
                            </div>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="sticky-bottom bg-white border-top p-3 mt-5 shadow-lg rounded-top">
                <div class="container d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i> Sélectionnez un objet pour débloquer l'envoi.
                    </div>
                    <div>
                        <a href="/" class="btn btn-link text-secondary">Annuler</a>
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            Proposer l'échange <i class="bi bi-send ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

</body>
</html>