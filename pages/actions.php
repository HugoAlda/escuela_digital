<div class="container section-title">
    <h2>Fase 2: Accions i Solucions</h2>
    <p>Aquestes són les solucions digitals concretes que proposem per als problemes detectats.</p>
</div>

<div class="container">
    <?php foreach ($actions as $item): ?>
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
            <div style="flex: 1 1 200px;">
                <h3 style="color: var(--primary-color);"><?= htmlspecialchars($item['process']) ?></h3>
                <h4><?= htmlspecialchars($item['action']) ?></h4>
            </div>
            <div style="flex: 2 1 400px;">
                <p><strong>Descripció:</strong> <?= htmlspecialchars($item['desc']) ?></p>
                <div style="margin-top: 10px;">
                    <span class="badge" style="background-color: var(--secondary-color);">Eines: <?= htmlspecialchars($item['tools']) ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div class="text-center mt-4">
        <a href="index.php?page=implementation" class="btn">Full de Ruta</a>
    </div>
</div>
