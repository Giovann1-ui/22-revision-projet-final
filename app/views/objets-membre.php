<?php 
$base_url = Flight::get('base_url');
$objets = $objets ?? [];
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objets disponibles - Takalo</title>
    
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        body { padding-top: 80px; }
        .object-card { transition: transform 0.2s, box-shadow 0.2s; }
        .object-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
        .filter-sidebar { position: sticky; top: 100px; }
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
        <div class="row">
            <!-- Filtres latéraux -->
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-funnel me-2"></i>Filtres
                            </h5>
                            
                            <!-- Recherche -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Rechercher</label>
                                <input type="text" class="form-control form-control-sm" 
                                       placeholder="Titre, description..." id="searchInput">
                            </div>
                            
                            <!-- Catégorie -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Catégorie</label>
                                <select class="form-select form-select-sm" id="categoryFilter">
                                    <option value="">Toutes</option>
                                    <option value="1">Électronique</option>
                                    <option value="2">Vêtements</option>
                                    <option value="3">Livres</option>
                                    <option value="4">Meubles</option>
                                    <option value="5">Sports & Loisirs</option>
                                </select>
                            </div>
                            
                            <!-- Prix -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Prix max</label>
                                <input type="range" class="form-range" min="0" max="1000" step="50" 
                                       id="priceRange" value="1000">
                                <small class="text-muted">Jusqu'à <span id="priceValue">1000</span> €</small>
                            </div>
                            
                            <button class="btn btn-sm btn-outline-secondary w-100" onclick="resetFilters()">
                                <i class="bi bi-x-circle me-1"></i>Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des objets -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Objets disponibles</h2>
                        <p class="text-muted mb-0">
                            <span id="objectCount"><?= count($objets) ?></span> objet(s) trouvé(s)
                        </p>
                    </div>
                    <select class="form-select form-select-sm" style="width: auto;" id="sortSelect">
                        <option value="recent">Plus récents</option>
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                        <option value="name">Nom A-Z</option>
                    </select>
                </div>

                <div class="row g-4" id="objectsGrid">
                    <?php if (empty($objets)): ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3">Aucun objet disponible</h5>
                            <p class="text-muted">Revenez plus tard pour découvrir de nouveaux objets</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($objets as $objet): ?>
                            <div class="col-md-6 col-lg-4 object-item" 
                                 data-name="<?= strtolower(htmlspecialchars($objet['nom'])) ?>"
                                 data-category="<?= $objet['id_categorie'] ?>"
                                 data-price="<?= $objet['prix_estimatif'] ?>">
                                <div class="card h-100 shadow-sm object-card">
                                    <!-- Image -->
                                    <?php if (!empty($objet['images']) && $objet['images'][0]): ?>
                                        <div id="carousel-<?= $objet['id'] ?>" class="carousel slide">
                                            <div class="carousel-inner">
                                                <?php foreach ($objet['images'] as $key => $image): ?>
                                                    <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                                        <img src="<?= htmlspecialchars($image['url']) ?>" 
                                                             class="d-block w-100" 
                                                             style="height: 200px; object-fit: cover;" 
                                                             alt="<?= htmlspecialchars($objet['nom']) ?>">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if (count($objet['images']) > 1): ?>
                                                <button class="carousel-control-prev" type="button" 
                                                        data-bs-target="#carousel-<?= $objet['id'] ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" 
                                                        data-bs-target="#carousel-<?= $objet['id'] ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light" 
                                             style="height: 200px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-primary"><?= htmlspecialchars($objet['nom_categorie']) ?></span>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i><?= htmlspecialchars($objet['nom_membre']) ?>
                                            </small>
                                        </div>
                                        
                                        <h5 class="card-title"><?= htmlspecialchars($objet['nom']) ?></h5>
                                        <p class="card-text text-muted small">
                                            <?= htmlspecialchars(substr($objet['description'], 0, 80)) ?>...
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="text-success fw-bold">
                                                <i class="bi bi-tag me-1"></i><?= number_format($objet['prix_estimatif'], 2) ?> €
                                            </span>
                                            <a href="/objets/<?= $objet['id'] ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Voir
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-top-0">
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            <?= date('d/m/Y', strtotime($objet['date_creation'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        const sortSelect = document.getElementById('sortSelect');
        const objectItems = document.querySelectorAll('.object-item');
        const objectCount = document.getElementById('objectCount');

        // Filtrage
        function filterObjects() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;
            const maxPrice = parseFloat(priceRange.value);
            
            let visibleCount = 0;
            
            objectItems.forEach(item => {
                const name = item.dataset.name;
                const category = item.dataset.category;
                const price = parseFloat(item.dataset.price);
                
                const matchSearch = !searchTerm || name.includes(searchTerm);
                const matchCategory = !selectedCategory || category === selectedCategory;
                const matchPrice = price <= maxPrice;
                
                if (matchSearch && matchCategory && matchPrice) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            objectCount.textContent = visibleCount;
        }

        // Tri
        function sortObjects() {
            const grid = document.getElementById('objectsGrid');
            const items = Array.from(objectItems);
            const sortBy = sortSelect.value;
            
            items.sort((a, b) => {
                switch(sortBy) {
                    case 'price-asc':
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    case 'price-desc':
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    case 'name':
                        return a.dataset.name.localeCompare(b.dataset.name);
                    default:
                        return 0;
                }
            });
            
            items.forEach(item => grid.appendChild(item));
        }

        // Réinitialiser
        function resetFilters() {
            searchInput.value = '';
            categoryFilter.value = '';
            priceRange.value = 1000;
            priceValue.textContent = '1000';
            filterObjects();
        }

        // Event listeners
        searchInput.addEventListener('input', filterObjects);
        categoryFilter.addEventListener('change', filterObjects);
        priceRange.addEventListener('input', (e) => {
            priceValue.textContent = e.target.value;
            filterObjects();
        });
        sortSelect.addEventListener('change', sortObjects);
    </script>
</body>
</html>