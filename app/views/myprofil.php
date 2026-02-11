<?php 
$base_url = Flight::get('base_url');
$user = $user ?? null;
$objets = $objets ?? [];
$stats = $stats ?? ['total_objets' => 0, 'valeur_totale' => 0];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Takalo</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/main-QD_VOj1Y.css">
    
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
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>
                            <span><?= htmlspecialchars($user['nom']) ?></span>
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" href="/profile"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="/"><i class="bi bi-house me-2"></i>Accueil</a></li>
                            <li><a class="dropdown-item" href="/mes-objets"><i class="bi bi-box me-2"></i>Mes objets</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- En-tête du profil -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px;">
                                    <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h2 class="mb-1"><?= htmlspecialchars($user['nom']) ?></h2>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Membre depuis <?= date('F Y', strtotime($user['date_creation'] ?? 'now')) ?>
                                </p>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="bi bi-pencil me-1"></i>Modifier le profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <h3 class="mb-0"><?= $stats['total_objets'] ?></h3>
                        <p class="text-muted mb-0">Objets en ligne</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-cash-stack text-success" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <h3 class="mb-0"><?= number_format($stats['valeur_totale'], 2) ?> €</h3>
                        <p class="text-muted mb-0">Valeur estimée totale</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mes objets -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3><i class="bi bi-box me-2"></i>Mes objets</h3>
                    <a href="/mes-objets/ajouter" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Ajouter un objet
                    </a>
                </div>
            </div>
        </div>

        <!-- Liste des objets -->
        <div class="row g-4">
            <?php if (empty($objets)): ?>
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3">Aucun objet</h5>
                            <p class="text-muted">Vous n'avez pas encore ajouté d'objets</p>
                            <a href="/mes-objets/ajouter" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-lg me-2"></i>Ajouter mon premier objet
                            </a>
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
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted" type="button" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="/mes-objets/modifier/<?= $objet['id'] ?>">
                                                    <i class="bi bi-pencil me-2"></i>Modifier
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                   onclick="deleteObjet(<?= $objet['id'] ?>); return false;">
                                                    <i class="bi bi-trash me-2"></i>Supprimer
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <h5 class="card-title"><?= htmlspecialchars($objet['nom']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars(substr($objet['description'], 0, 100)) ?>...</p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-success fw-bold">
                                        <i class="bi bi-tag me-1"></i>
                                        <?= number_format($objet['prix_estimatif'], 2) ?> €
                                    </span>
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
    </main>

    <!-- Modal Modifier Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="bi bi-pencil me-2"></i>Modifier le profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProfileForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="userName" name="nom" 
                                   value="<?= htmlspecialchars($user['nom']) ?>" required>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Seul le nom d'utilisateur peut être modifié pour le moment
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url ?>assets/vendor-bootstrap-C9iorZI5.js"></script>
    <script src="<?= $base_url ?>assets/vendor-ui-CflGdlft.js"></script>
    
    <script>
        // Modifier le profil
        document.getElementById('editProfileForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await fetch('/profile/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Fermer le modal
                    bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
                    
                    // Afficher un message de succès et recharger la page
                    alert('Profil mis à jour avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue');
            }
        });
        
        // Supprimer un objet
        async function deleteObjet(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet objet ?')) {
                return;
            }
            
            try {
                const response = await fetch(`/mes-objets/supprimer/${id}`, {
                    method: 'DELETE'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Objet supprimé avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue');
            }
        }
        
        // Initialiser les dropdowns Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
</body>
</html>