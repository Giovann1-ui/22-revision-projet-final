<?php 
$base_url = Flight::get('base_url');
$propositions_recues = $propositions_recues ?? [];
$propositions_envoyees = $propositions_envoyees ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Propositions - Takalo</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { padding-top: 80px; background-color: #f4f7f6; }
        
        .section-title {
            border-bottom: 2px solid #6366f1;
            padding-bottom: 10px;
            margin-bottom: 30px;
            color: #2d3748;
            font-weight: 700;
        }

        .proposition-card {
            border: none;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 6px solid #cbd5e0;
        }
        
        .en_attente { border-left-color: #fbbf24; }
        .acceptee { border-left-color: #10b981; }
        .refusee { border-left-color: #ef4444; }
        
        .objet-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 12px;
            background: #f8fafc;
            border-radius: 10px;
        }
        
        .objet-preview img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .exchange-icon {
            font-size: 1.5rem;
            color: #6366f1;
            animation: pulse 2s infinite;
            background: white;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 0 auto;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
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
        
        <div class="mb-5">
            <h3 class="section-title"><i class="bi bi-download me-2"></i>Propositions Reçues (<?= count($propositions_recues) ?>)</h3>
            
            <?php if (empty($propositions_recues)): ?>
                <div class="alert alert-light border">Vous n'avez reçu aucune proposition pour le moment.</div>
            <?php else: ?>
                <?php foreach ($propositions_recues as $prop): ?>
                    <div class="card proposition-card <?= htmlspecialchars($prop['statut']) ?> shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <small class="text-muted d-block mb-1">Votre objet</small>
                                    <div class="objet-preview">
                                        <!-- <?= $prop['objet_demande_images'][0]['url'] ?> -->
                                        <img src="/assets/images/<?= $prop['objet_demande_images'][0]['url'] ?>">
                                        <div class="overflow-hidden">
                                            <h6 class="mb-0 text-truncate"><?= htmlspecialchars($prop['objet1_nom']) ?></h6>
                                            <span class="text-primary fw-bold small"><?= number_format($prop['objet1_prix'], 2) ?> €</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 text-center my-2">
                                    <div class="exchange-icon"><i class="bi bi-arrow-left-right"></i></div>
                                </div>

                                <div class="col-md-5">
                                    <small class="text-muted d-block mb-1">Proposé par : <?= htmlspecialchars($prop['proposant_nom']) ?></small>
                                    <div class="objet-preview">
                                        <img src="/assets/images/<?= $prop['objet_propose_images'][0]['url'] ?? 'default.jpg' ?>">
                                        <div class="overflow-hidden">
                                            <h6 class="mb-0 text-truncate"><?= htmlspecialchars($prop['objet2_nom']) ?></h6>
                                            <span class="text-primary fw-bold small"><?= number_format($prop['objet2_prix'], 2) ?> €</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="badge bg-light text-dark border">
                                    Statut: <?= ucfirst(str_replace('_', ' ', $prop['statut'])) ?>
                                </span>
                                
                                <?php if ($prop['statut'] === 'En attente'): ?>
                                    <div class="btn-group">
                                        <form action="/propositions/<?= $prop['id'] ?>/refuser" method="POST" class="me-2">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Refuser</button>
                                        </form>
                                        <form action="/propositions/<?= $prop['id'] ?>/accepter" method="POST">
                                            <button type="submit" class="btn btn-success btn-sm px-3">Accepter</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <hr class="my-5">

        <div class="mb-5">
            <h3 class="section-title"><i class="bi bi-send me-2"></i>Propositions Envoyées (<?= count($propositions_envoyees) ?>)</h3>
            
            <?php if (empty($propositions_envoyees)): ?>
                <div class="alert alert-light border">Vous n'avez envoyé aucune proposition pour le moment.</div>
            <?php else: ?>
                <?php foreach ($propositions_envoyees as $prop): ?>
                    <div class="card proposition-card <?= htmlspecialchars($prop['statut']) ?> shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <small class="text-muted d-block mb-1">Votre objet proposé</small>
                                    <div class="objet-preview">
                                        <img src="/assets/images/<?= $prop['objet_propose_images'][0]['url'] ?? 'default.jpg' ?>">
                                        <div class="overflow-hidden">
                                            <h6 class="mb-0 text-truncate"><?= htmlspecialchars($prop['objet2_nom']) ?></h6>
                                            <span class="text-primary fw-bold small"><?= number_format($prop['objet2_prix'], 2) ?> €</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 text-center my-2">
                                    <div class="exchange-icon"><i class="bi bi-arrow-left-right"></i></div>
                                </div>

                                <div class="col-md-5">
                                    <small class="text-muted d-block mb-1">Demandé à : <?= htmlspecialchars($prop['destinataire_nom']) ?></small>
                                    <div class="objet-preview">
                                        <img src="/assets/images/<?= $prop['objet_demande_images'][0]['url'] ?? 'default.jpg' ?>">
                                        <div class="overflow-hidden">
                                            <h6 class="mb-0 text-truncate"><?= htmlspecialchars($prop['objet1_nom']) ?></h6>
                                            <span class="text-primary fw-bold small"><?= number_format($prop['objet1_prix'], 2) ?> €</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="badge bg-light text-dark border">
                                    Statut: <?= ucfirst(str_replace('_', ' ', $prop['statut'])) ?>
                                </span>
                                
                                <?php if ($prop['statut'] === 'En attente'): ?>
                                    <form action="/propositions/<?= $prop['id'] ?>/annuler" method="POST">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Annuler la demande</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>