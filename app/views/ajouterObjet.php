<?php 
$base_url = Flight::get('base_url');
$categories = $categories ?? [];
$error = $error ?? '';
$user = $_SESSION['user'] ?? ['nom' => 'Utilisateur'];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un objet - Takalo</title>
    
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

        .char-counter {
            text-align: right;
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .char-counter.warning {
            color: #ffc107;
        }

        .char-counter.danger {
            color: #dc3545;
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
                            <span><?= htmlspecialchars($_SESSION['user_nom'] ?? 'Utilisateur') ?></span>
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>Profil</a></li>
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
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-fill"></i></a></li>
                <li class="breadcrumb-item"><a href="/profile">Mon profil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter un objet</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">
                            <i class="bi bi-plus-circle text-primary me-2"></i>Ajouter un objet
                        </h2>
                        <p class="text-muted mb-0">Remplissez les informations pour publier votre objet</p>
                    </div>
                    <a href="/profile" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Informations de l'objet</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/mes-objets/ajouter" id="addObjectForm" class="needs-validation" novalidate>
                            <!-- Nom de l'objet -->
                            <div class="mb-4">
                                <label for="nom" class="form-label fw-semibold">
                                    <i class="bi bi-tag me-1"></i>Nom de l'objet <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="nom" name="nom" 
                                       placeholder="Ex: iPhone 12, Vélo de montagne..." 
                                       maxlength="255" required>
                                <div class="invalid-feedback">
                                    <i class="bi bi-x-circle me-1"></i>Veuillez entrer un nom pour l'objet
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="bi bi-text-paragraph me-1"></i>Description <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="description" name="description" rows="5" 
                                          placeholder="Décrivez votre objet en détail (état, accessoires inclus, raison de l'échange...)"
                                          maxlength="1000" required></textarea>
                                <div class="char-counter" id="charCounter">0 / 1000 caractères</div>
                                <div class="invalid-feedback">
                                    <i class="bi bi-x-circle me-1"></i>Veuillez entrer une description
                                </div>
                            </div>

                            <!-- Row: Prix et Catégorie -->
                            <div class="row g-4 mb-4">
                                <!-- Prix estimatif -->
                                <div class="col-md-6">
                                    <label for="prix_estimatif" class="form-label fw-semibold">
                                        <i class="bi bi-currency-euro me-1"></i>Prix estimatif (€) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" class="form-control" id="prix_estimatif" name="prix_estimatif" 
                                               step="0.01" min="0" placeholder="0.00" required>
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>Estimation pour faciliter les échanges
                                    </div>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-x-circle me-1"></i>Veuillez entrer un prix estimatif valide
                                    </div>
                                </div>

                                <!-- Catégorie -->
                                <div class="col-md-6">
                                    <label for="id_categorie" class="form-label fw-semibold">
                                        <i class="bi bi-grid me-1"></i>Catégorie <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg" id="id_categorie" name="id_categorie" required>
                                        <option value="" selected disabled>Choisir une catégorie...</option>
                                        <?php foreach ($categories as $categorie): ?>
                                            <option value="<?= $categorie['id'] ?>">
                                                <?= htmlspecialchars($categorie['nom']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-x-circle me-1"></i>Veuillez sélectionner une catégorie
                                    </div>
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="alert alert-info d-flex align-items-start" role="alert">
                                <i class="bi bi-lightbulb-fill me-2 mt-1" style="font-size: 1.25rem;"></i>
                                <div>
                                    <strong>Conseil :</strong> Les objets avec une description complète et un prix réaliste 
                                    reçoivent en moyenne 3× plus de propositions d'échange !
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                                <a href="/profile" class="btn btn-lg btn-outline-secondary">
                                    <i class="bi bi-x-lg me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Publier l'objet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap Bundle JS local -->
    <script src="<?= $base_url ?>css/bootstrap.bundle.min.js" nonce="<?= Flight::get('csp_nonce') ?>"></script>
    
    <script nonce="<?= Flight::get('csp_nonce') ?>">
        // Attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            
            // Validation Bootstrap
            const form = document.getElementById('addObjectForm');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            // Compteur de caractères pour la description
            const descriptionField = document.getElementById('description');
            const charCounter = document.getElementById('charCounter');
            
            descriptionField.addEventListener('input', function() {
                const length = this.value.length;
                const maxLength = 1000;
                charCounter.textContent = length + ' / ' + maxLength + ' caractères';
                
                // Changer la couleur en fonction du nombre de caractères
                if (length > 900) {
                    charCounter.classList.add('danger');
                    charCounter.classList.remove('warning');
                } else if (length > 800) {
                    charCounter.classList.add('warning');
                    charCounter.classList.remove('danger');
                } else {
                    charCounter.classList.remove('warning', 'danger');
                }
            });

            // Formatage automatique du prix
            const prixField = document.getElementById('prix_estimatif');
            prixField.addEventListener('blur', function() {
                if (this.value) {
                    const value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    }
                }
            });

            // Initialiser les dropdowns Bootstrap
            var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
</body>
</html>