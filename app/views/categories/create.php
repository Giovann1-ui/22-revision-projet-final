<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Catégorie</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter une Catégorie</h1>
        <form method="post" action="/categories/store">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la Catégorie</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="/categories" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>

