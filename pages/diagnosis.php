<div class="container section-title">
    <h2>Fase 1: Diagnòstic del Centre</h2>
    <p>Hem analitzat els processos actuals de l'escola i hem identificat els punts crítics següents:</p>
</div>

<div class="container">
    <div class="card-grid">
        <?php foreach ($diagnosis as $item): ?>
        <div class="card">
            <div class="card-icon"><i class="fa <?= htmlspecialchars($item['icon']) ?>"></i></div>
            <h3><?= htmlspecialchars($item['process']) ?></h3>
            <p><strong>Problema:</strong> <?= htmlspecialchars($item['problem']) ?></p>
            <p><strong>Impacte:</strong> <?= htmlspecialchars($item['impact']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php?page=objectives" class="btn">Continuar a Objectius</a>
    </div>
</div>
