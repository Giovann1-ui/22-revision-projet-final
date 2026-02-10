<?php 
$base_url = Flight::get('base_url');
$categories = $categories ?? [];
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un objet - Takalo</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a href="/profile" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Retour au profil
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5" style="padding-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter un objet
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/mes-objets/ajouter" class="needs-validation" novalidate>
                            <!-- Nom de l'objet -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de l'objet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" 
                                       placeholder="Ex: iPhone 12, Vélo de montagne..." required>
                                <div class="invalid-feedback">
                                    Veuillez entrer un nom pour l'objet
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" 
                                          placeholder="Décrivez votre objet en détail..." required></textarea>
                                <div class="invalid-feedback">
                                    Veuillez entrer une description
                                </div>
                            </div>

                            <!-- Prix estimatif -->
                            <div class="mb-3">
                                <label for="prix_estimatif" class="form-label">Prix estimatif (€) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="prix_estimatif" name="prix_estimatif" 
                                           step="0.01" min="0" placeholder="0.00" required>
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="form-text">Indiquez une estimation de la valeur de votre objet</div>
                                <div class="invalid-feedback">
                                    Veuillez entrer un prix estimatif
                                </div>
                            </div>

                            <!-- Catégorie -->
                            <div class="mb-4">
                                <label for="id_categorie" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_categorie" name="id_categorie" required>
                                    <option value="">Choisir une catégorie...</option>
                                    <?php foreach ($categories as $categorie): ?>
                                        <option value="<?= $categorie['id'] ?>">
                                            <?= htmlspecialchars($categorie['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Veuillez sélectionner une catégorie
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/profile" class="btn btn-secondary">
                                    <i class="bi bi-x-lg me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Ajouter l'objet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Validation Bootstrap
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>