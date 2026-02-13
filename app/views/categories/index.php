<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Catégories</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Gestion des Catégories</h1>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Utilisateurs Inscrits</h5>
                        <p class="card-text display-4"><?php echo $userCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Échanges Effectués</h5>
                        <p class="card-text display-4"><?php echo $exchangeCount; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <a href="/categories/create" class="btn btn-primary mb-3">Add Categories</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo htmlspecialchars($category['nom']); ?></td>
                    <td>
                        <form method="post" action="/categories/delete" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="post" action="/logout" style="display:inline;">
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
</body>
</html>