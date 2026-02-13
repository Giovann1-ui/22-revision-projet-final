<?php
echo $objet['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Éditer un objet</title>

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons (local) -->
    <link rel="stylesheet" href="/bootstrap-icons/font/bootstrap-icons.css" />
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-box-seam me-2"></i>Takalo
            </a>
            <div class="ms-auto">
                <a class="btn btn-outline-secondary btn-sm" href="/profile">
                    <i class="bi bi-person-circle me-1"></i>Mon profil
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="h4 mb-4">
                            <i class="bi bi-pencil-square me-2"></i>Éditer un objet
                        </h1>

                        <form method="POST" action="/mes-objets/edit" enctype="multipart/form-data" novalidate>
                            <input type="hidden" name="idObjet" value="<?= $objet['id'] ?>" />
                            <!-- Titre -->
                            <div class="mb-3">
                                <label for="nom" class="form-label fw-semibold">Titre de l’objet</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                       value="<?= $objet['nom'] ?>" required />
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5"
                                          placeholder="<?= $objet['description'] ?>" required><?= $objet['description'] ?></textarea>
                            </div>

                            <!-- Prix estimatif -->
                            <div class="mb-3">
                                <label for="prix_estimatif" class="form-label fw-semibold">Prix estimatif</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-currency-euro"></i></span>
                                    <input type="number" class="form-control" id="prix_estimatif" name="prix_estimatif"
                                           step="0.01" min="0" value="<?= $objet['prix_estimatif'] ?>" required />
                                </div>
                            </div>

                            <!-- Images actuelles -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Images actuelles</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <!-- Exemple de vignette -->
                                     <!-- // TODO : afficher toutes les images de l'objet -->
                                    <?php foreach ($objet['images'] as $image): ?>
                                        <div class="border rounded p-2 d-flex align-items-center gap-2">
                                            <img src="/assets/images/<?= $image ?>" alt="Image" width="60" height="60"
                                                 class="rounded object-fit-cover" />
                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <?php endforeach; ?>
                                    <!-- ... -->
                                </div>
                                <div class="form-text">Supprimez les images que vous ne voulez plus.</div>
                            </div>

                            <!-- Ajouter des images -->
                            <div class="mb-4">
                                <label for="images" class="form-label fw-semibold">Ajouter une image</label>
                                <input type="file" class="form-control" id="images" name="image" multiple accept="image/*" />
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-2">
                                <a href="/mes-objets" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-muted small mt-3">
                    Astuce : gardez un titre clair et une description précise.
                </p>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>