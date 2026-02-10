<?php 
$base_url = Flight::get('base_url');
$categories = $categories ?? [];
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un objet • Takalo</title>
    
    <link rel="icon" type="image/svg+xml" href="<?= $base_url ?>assets/favicon-CvUZKS4z.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #eef2ff;
            --accent: #10b981;
            --accent-light: #ecfdf5;
            --surface: #ffffff;
            --surface-dim: #f8fafc;
            --border: #e2e8f0;
            --border-focus: #6366f1;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--surface-dim);
            color: var(--text-primary);
            min-height: 100vh;
            padding-top: 72px;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Navbar ─── */
        .top-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1030;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border-bottom: 1px solid var(--border);
            height: 72px;
            display: flex;
            align-items: center;
        }

        .top-nav .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--primary);
        }

        .brand img { height: 32px; }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-actions .btn {
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--radius-sm);
        }

        /* ─── Layout ─── */
        .page-shell {
            max-width: 960px;
            margin: 0 auto;
            padding: 2rem 1rem 4rem;
        }

        /* ─── Breadcrumb ─── */
        .breadcrumb-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .breadcrumb-bar a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .breadcrumb-bar a:hover { color: var(--primary); }
        .breadcrumb-bar .sep { margin: 0 2px; }
        .breadcrumb-bar .current { color: var(--text-primary); font-weight: 600; }

        /* ─── Page Header ─── */
        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        /* ─── Progress Steps ─── */
        .steps {
            display: flex;
            gap: 0;
            margin-bottom: 2.5rem;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .step {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 1.25rem;
            position: relative;
            font-size: 0.875rem;
            color: var(--text-muted);
            transition: all 0.25s ease;
        }

        .step + .step { border-left: 1px solid var(--border); }

        .step.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .step.completed {
            background: var(--accent-light);
            color: var(--accent);
        }

        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
            background: var(--border);
            color: var(--text-muted);
            transition: all 0.25s ease;
        }

        .step.active .step-num {
            background: var(--primary);
            color: white;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
        }

        .step.completed .step-num {
            background: var(--accent);
            color: white;
        }

        .step-label { font-weight: 600; line-height: 1.2; }
        .step-desc { font-size: 0.75rem; font-weight: 400; opacity: 0.8; }

        /* ─── Card ─── */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .form-card-body {
            padding: 2.5rem;
        }

        /* ─── Section ─── */
        .form-section + .form-section {
            margin-top: 2.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid var(--border);
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .section-icon.blue  { background: var(--primary-light); color: var(--primary); }
        .section-icon.green { background: var(--accent-light);  color: var(--accent);  }

        .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .section-hint {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        /* ─── Form Controls ─── */
        .field-group { margin-bottom: 1.5rem; }
        .field-group:last-child { margin-bottom: 0; }

        .field-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .field-label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        .field-label .optional {
            color: var(--text-muted);
            font-weight: 400;
            font-size: 0.8rem;
            margin-left: 4px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .trailing-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--text-primary);
            background: var(--surface);
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .form-control:hover, .form-select:hover {
            border-color: #cbd5e1;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            outline: none;
        }

        .form-control:focus ~ .trailing-icon {
            color: var(--primary);
        }

        .form-control.is-valid {
            border-color: var(--accent);
            box-shadow: none;
        }

        .form-control.is-valid:focus {
            box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }

        .form-control.price-field {
            font-weight: 700;
            font-size: 1.15rem;
            padding-right: 3rem;
            font-variant-numeric: tabular-nums;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 140px;
            line-height: 1.6;
        }

        .char-count {
            text-align: right;
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
            font-variant-numeric: tabular-nums;
            transition: color 0.2s;
        }

        .char-count.warn { color: #f59e0b; font-weight: 600; }
        .char-count.over { color: #ef4444; font-weight: 700; }

        .field-help {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            display: none;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            color: #ef4444;
        }

        .was-validated .form-control:invalid ~ .invalid-feedback,
        .was-validated .form-select:invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-feedback,
        .form-select.is-invalid ~ .invalid-feedback {
            display: flex;
        }

        /* ─── Tip ─── */
        .tip-box {
            display: flex;
            gap: 14px;
            padding: 1rem 1.25rem;
            background: var(--accent-light);
            border: 1px solid rgba(16,185,129,0.2);
            border-radius: var(--radius-md);
            margin-top: 1.5rem;
        }

        .tip-box i { color: var(--accent); font-size: 1.25rem; flex-shrink: 0; margin-top: 2px; }
        .tip-box p { margin: 0; font-size: 0.875rem; color: #065f46; line-height: 1.5; }
        .tip-box strong { font-weight: 600; }

        /* ─── Alert ─── */
        .form-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .form-alert.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .form-alert i { font-size: 1.15rem; flex-shrink: 0; margin-top: 1px; }

        /* ─── Footer Actions ─── */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2.5rem;
            background: var(--surface-dim);
            border-top: 1px solid var(--border);
        }

        .form-footer .btn {
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            padding: 0.65rem 1.5rem;
            transition: all 0.2s ease;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.65rem 2rem !important;
            box-shadow: 0 1px 2px rgba(99,102,241,0.3);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.3);
            color: white;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            border: 1.5px solid var(--border);
        }

        .btn-ghost:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .btn-link-muted {
            background: none;
            border: none;
            color: var(--text-muted);
            font-weight: 500;
            padding: 0.65rem 1rem !important;
        }

        .btn-link-muted:hover {
            color: var(--text-secondary);
            background: rgba(0,0,0,0.03);
            border-radius: var(--radius-sm);
        }

        /* ─── Spinner ─── */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ─── Toast ─── */
        .toast-container {
            position: fixed;
            top: 84px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            animation: toastIn 0.3s ease-out;
            max-width: 320px;
        }

        .toast-item.success { border-left: 3px solid var(--accent); }
        .toast-item.info    { border-left: 3px solid var(--primary); }

        .toast-item.removing {
            animation: toastOut 0.25s ease-in forwards;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(40px); }
        }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .page-shell { padding: 1.25rem 0.75rem 3rem; }
            .form-card-body { padding: 1.5rem; }
            .form-footer { padding: 1.25rem 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
            .form-footer .right-actions { width: 100%; display: flex; gap: 8px; }
            .form-footer .right-actions .btn { flex: 1; }
            .page-title { font-size: 1.4rem; }

            .steps { flex-direction: column; }
            .step + .step { border-left: none; border-top: 1px solid var(--border); }

            .breadcrumb-bar { display: none; }
        }

        @media (max-width: 480px) {
            .form-card-body { padding: 1.25rem; }
            .form-footer { padding: 1rem; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="top-nav">
        <div class="container-fluid px-3 px-md-4">
            <a href="/" class="brand">
                <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23logoGradient)'/%3e%3cpath%20d='M10%2024V8h2.5l2.5%206.5L17.5%208H20v16h-2V12.5L16.5%2020h-1L14%2012.5V24H10z'%20fill='white'%20font-weight='700'/%3e%3cdefs%3e%3clinearGradient%20id='logoGradient'%20x1='0'%20y1='0'%20x2='32'%20y2='32'%3e%3cstop%20offset='0%25'%20stop-color='%236366f1'/%3e%3cstop%20offset='100%25'%20stop-color='%238b5cf6'/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e" alt="Logo">
                Takalo
            </a>
            <div class="nav-actions">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/profile" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['user_nom']) ?>
                    </a>
                    <a href="/" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex">
                        <i class="bi bi-house me-1"></i>Accueil
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-sm btn-primary">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Page Content -->
    <div class="page-shell">

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <a href="/"><i class="bi bi-house-fill"></i></a>
            <span class="sep">›</span>
            <a href="/profile">Mon profil</a>
            <span class="sep">›</span>
            <span class="current">Ajouter un objet</span>
        </div>

        <!-- Page Header -->
        <h1 class="page-title">Nouvel objet</h1>
        <p class="page-subtitle">Remplissez les informations ci-dessous pour publier votre objet à l'échange.</p>

        <!-- Steps -->
        <div class="steps">
            <div class="step active" data-step="1">
                <div class="step-num">1</div>
                <div>
                    <div class="step-label">Informations</div>
                    <div class="step-desc d-none d-md-block">Nom et description</div>
                </div>
            </div>
            <div class="step" data-step="2">
                <div class="step-num">2</div>
                <div>
                    <div class="step-label">Détails</div>
                    <div class="step-desc d-none d-md-block">Prix et catégorie</div>
                </div>
            </div>
            <div class="step" data-step="3">
                <div class="step-num">3</div>
                <div>
                    <div class="step-label">Publication</div>
                    <div class="step-desc d-none d-md-block">Vérification et envoi</div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-card-body">

                <?php if ($error): ?>
                    <div class="form-alert error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Erreur de validation</strong><br>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/mes-objets/ajouter" id="addObjectForm" novalidate>

                    <!-- Section 1 : Informations -->
                    <div class="form-section">
                        <div class="section-label">
                            <div class="section-icon blue">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div>
                                <h2 class="section-title">Informations de base</h2>
                                <p class="section-hint">Donnez un titre clair et une description honnête.</p>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="nom">
                                Titre de l'objet <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <input type="text"
                                       class="form-control"
                                       id="nom"
                                       name="nom"
                                       placeholder="ex : iPhone 12 Pro – 128 Go Bleu Pacifique"
                                       maxlength="255"
                                       autocomplete="off"
                                       required>
                                <i class="bi bi-tag trailing-icon"></i>
                            </div>
                            <div class="invalid-feedback">
                                <i class="bi bi-x-circle-fill"></i>
                                Veuillez saisir un titre pour votre objet.
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="description">
                                Description <span class="required">*</span>
                            </label>
                            <textarea class="form-control"
                                      id="description"
                                      name="description"
                                      rows="5"
                                      maxlength="1000"
                                      placeholder="Décrivez l'état, les accessoires inclus, la raison de l'échange…"
                                      required></textarea>
                            <div class="char-count" id="charCount">0 / 1 000</div>
                            <div class="invalid-feedback">
                                <i class="bi bi-x-circle-fill"></i>
                                Une description aide les autres membres à évaluer votre objet.
                            </div>
                        </div>
                    </div>

                    <!-- Section 2 : Détails -->
                    <div class="form-section">
                        <div class="section-label">
                            <div class="section-icon green">
                                <i class="bi bi-sliders"></i>
                            </div>
                            <div>
                                <h2 class="section-title">Détails</h2>
                                <p class="section-hint">Estimez la valeur et choisissez la bonne catégorie.</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label" for="prix_estimatif">
                                        Valeur estimée <span class="required">*</span>
                                    </label>
                                    <div class="input-wrap">
                                        <input type="number"
                                               class="form-control price-field"
                                               id="prix_estimatif"
                                               name="prix_estimatif"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00"
                                               required>
                                        <i class="bi bi-currency-euro trailing-icon"></i>
                                    </div>
                                    <div class="field-help">
                                        <i class="bi bi-info-circle"></i>
                                        Estimation pour aider les échanges équitables.
                                    </div>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Indiquez un prix estimatif valide.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label" for="id_categorie">
                                        Catégorie <span class="required">*</span>
                                    </label>
                                    <select class="form-select"
                                            id="id_categorie"
                                            name="id_categorie"
                                            required>
                                        <option value="" selected disabled>Choisir une catégorie…</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Sélectionnez une catégorie.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tip -->
                        <div class="tip-box">
                            <i class="bi bi-lightbulb-fill"></i>
                            <p>
                                <strong>Astuce :</strong> les objets avec une description complète 
                                et un prix réaliste reçoivent <strong>3× plus de propositions</strong> d'échange.
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer Actions -->
            <div class="form-footer">
                <button type="button" class="btn btn-link-muted" id="saveDraftBtn">
                    <i class="bi bi-bookmark me-1"></i>Brouillon
                </button>
                <div class="right-actions d-flex gap-2">
                    <a href="/profile" class="btn btn-ghost">Annuler</a>
                    <button type="submit" form="addObjectForm" class="btn btn-submit" id="submitBtn">
                        <i class="bi bi-plus-lg me-1"></i>Publier l'objet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (() => {
        const $ = (s, c = document) => c.querySelector(s);
        const form          = $('#addObjectForm');
        const descInput     = $('#description');
        const charCount     = $('#charCount');
        const submitBtn     = $('#submitBtn');
        const saveDraftBtn  = $('#saveDraftBtn');
        const toastBox      = $('#toastContainer');
        const steps         = document.querySelectorAll('.step');
        const DRAFT_KEY     = 'takalo_draft';

        // ── Toast ──
        function toast(msg, type = 'info') {
            const el = document.createElement('div');
            el.className = `toast-item ${type}`;
            el.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'info-circle-fill'}"></i><span>${msg}</span>`;
            toastBox.appendChild(el);
            setTimeout(() => { el.classList.add('removing'); setTimeout(() => el.remove(), 250); }, 3500);
        }

        // ── Character counter ──
        function updateCount() {
            const len = descInput.value.length;
            charCount.textContent = `${len.toLocaleString('fr-FR')} / 1 000`;
            charCount.classList.toggle('warn', len > 800 && len <= 950);
            charCount.classList.toggle('over', len > 950);
        }
        descInput.addEventListener('input', updateCount);

        // ── Live validation ──
        function validateField(el) {
            if (el.checkValidity()) {
                el.classList.remove('is-invalid');
                el.classList.add('is-valid');
            } else {
                el.classList.remove('is-valid');
                el.classList.add('is-invalid');
            }
        }

        form.querySelectorAll('input, textarea, select').forEach(el => {
            el.addEventListener('blur', () => validateField(el));
            el.addEventListener('input', () => { if (el.classList.contains('is-invalid')) validateField(el); });
        });

        // ── Step tracking ──
        function refreshSteps() {
            const nom  = !!$('#nom').value.trim();
            const desc = !!descInput.value.trim();
            const prix = !!$('#prix_estimatif').value;
            const cat  = !!$('#id_categorie').value;

            const s1Done = nom && desc;
            const s2Done = prix && cat;

            steps[0].classList.toggle('active', !s1Done);
            steps[0].classList.toggle('completed', s1Done);
            steps[1].classList.toggle('active', s1Done && !s2Done);
            steps[1].classList.toggle('completed', s1Done && s2Done);
            steps[2].classList.toggle('active', s1Done && s2Done);
        }

        form.addEventListener('input', refreshSteps);
        form.addEventListener('change', refreshSteps);

        // ── Form submit ──
        form.addEventListener('submit', e => {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                form.classList.add('was-validated');
                const first = form.querySelector(':invalid');
                if (first) { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); first.focus(); }
                return;
            }

            // show spinner
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner"></span>Publication…';
            localStorage.removeItem(DRAFT_KEY);
        });

        // ── Draft ──
        function saveDraft() {
            const data = {};
            new FormData(form).forEach((v, k) => { data[k] = v; });
            data._ts = Date.now();
            localStorage.setItem(DRAFT_KEY, JSON.stringify(data));
        }

        function loadDraft() {
            const raw = localStorage.getItem(DRAFT_KEY);
            if (!raw) return;
            try {
                const data = JSON.parse(raw);
                Object.entries(data).forEach(([k, v]) => {
                    if (k.startsWith('_')) return;
                    const el = form.querySelector(`[name="${k}"]`);
                    if (el) el.value = v;
                });
                updateCount();
                refreshSteps();
                toast('Brouillon restauré', 'info');
            } catch {}
        }

        let draftTimer;
        form.addEventListener('input', () => {
            clearTimeout(draftTimer);
            draftTimer = setTimeout(() => saveDraft(), 2000);
        });

        saveDraftBtn.addEventListener('click', () => {
            saveDraft();
            toast('Brouillon sauvegardé', 'success');
            saveDraftBtn.innerHTML = '<i class="bi bi-check2 me-1"></i>Sauvegardé';
            setTimeout(() => { saveDraftBtn.innerHTML = '<i class="bi bi-bookmark me-1"></i>Brouillon'; }, 2000);
        });

        // ── Price formatting ──
        $('#prix_estimatif').addEventListener('blur', function() {
            if (this.value) {
                const v = parseFloat(this.value);
                if (!isNaN(v)) this.value = v.toFixed(2);
            }
        });

        // ── Init ──
        loadDraft();
        refreshSteps();
    })();
    </script>
</body>
</html>