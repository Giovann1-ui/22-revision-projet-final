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
                    <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='32%2032%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23logoGradient)'/%3e%3cpath%20d='M10%2024V8h2.5l2.5%206.5L17.5%208H20v16h-2V12.5L16.5%2020h-1L14%2012.5V24H10z'%20fill='white'%20font-weight='700'/%3e%3cdefs%3e%3clinearGradient%20id='logoGradient'%20x1='0'%20y1='0'%20x2='32'%20y2='32'%3e%3cstop%20offset='0%25'%20stop-color='%236366f1'/%3e%3cstop%20offset='100%25'%20stop-color='%238b5cf6'/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e"
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
                                    <button class="btn btn-sm btn-danger btn-delete-objet" 
                                            data-objet-id="<?= $objet['id'] ?>"
                                            title="Supprimer cet objet">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
                            
                            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    Ajouté le <?= date('d/m/Y', strtotime($objet['date_creation'])) ?>
                                </small>
                                <!-- <a href="/mes-objets/modifier/<?= $objet['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary"
                                   title="Modifier cet objet">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </a> -->
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

    <!-- Bootstrap Bundle JS local -->
    <script src="<?= $base_url ?>css/bootstrap.bundle.min.js" nonce="<?= Flight::get('csp_nonce') ?>"></script>
    
    <script nonce="<?= Flight::get('csp_nonce') ?>">
        // Attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            
            // Modifier le profil
            const editProfileForm = document.getElementById('editProfileForm');
            if (editProfileForm) {
                editProfileForm.addEventListener('submit', async function(e) {
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
                            const modal = document.getElementById('editProfileModal');
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                            
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
            }
            
            // Fonction de suppression d'objet
            async function deleteObjet(id) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet objet ? Cette action est irréversible.')) {
                    return;
                }
                
                console.log('Tentative de suppression de l\'objet ID:', id);
                
                try {
                    const url = `/mes-objets/supprimer/${id}`;
                    console.log('URL de suppression:', url);
                    
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    console.log('Status de réponse:', response.status);
                    
                    // Vérifier si la réponse est en JSON
                    const contentType = response.headers.get("content-type");
                    console.log('Content-Type:', contentType);
                    
                    if (!contentType || !contentType.includes("application/json")) {
                        const text = await response.text();
                        console.error('Réponse non-JSON:', text);
                        alert('Erreur: La réponse du serveur n\'est pas au format JSON');
                        return;
                    }
                    
                    const result = await response.json();
                    console.log('Résultat:', result);
                    
                    if (result.success) {
                        // Afficher une notification de succès
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                        alertDiv.style.zIndex = '9999';
                        alertDiv.innerHTML = `
                            <i class="bi bi-check-circle-fill me-2"></i>
                            ${result.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.body.appendChild(alertDiv);
                        
                        // Recharger après 1 seconde
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert('Erreur: ' + result.message);
                    }
                } catch (error) {
                    console.error('Erreur complète:', error);
                    alert('Une erreur est survenue lors de la suppression: ' + error.message);
                }
            }
            
            // Attacher les event listeners aux boutons de suppression
            const deleteButtons = document.querySelectorAll('.btn-delete-objet');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const objetId = this.getAttribute('data-objet-id');
                    deleteObjet(objetId);
                });
            });
            
        });
    </script>
</body>
</html>