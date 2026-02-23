<div class="container section-title">
    <h2>Seguiment i Avaluació</h2>
    <p>Indicadors Clau d'Acompliment (KPIs) per mesurar l'èxit del PTD.</p>
</div>

<div class="container">
    <div class="card-grid">
        <?php foreach ($monitoring as $item): ?>
        <div class="card metric-card">
            <h3><?= htmlspecialchars($item['metric']) ?></h3>
            <div class="metric-value"><?= htmlspecialchars($item['target']) ?></div>
            <p>Freqüència de revisió: <?= htmlspecialchars($item['freq']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-4">
        <h3>Propera Revisió: Juliol 2026</h3>
    </div>
</div>
