<div class="container section-title">
    <h2>Fase 3: Objectius del PTD</h2>
    <p>La nostra meta és transformar l'escola digitalment en 1 any.</p>
</div>

<div class="container">
    <div class="card-grid">
        <?php foreach ($objectives as $item): ?>
        <div class="card" style="text-align: center;">
            <div class="card-icon" style="font-size: 3rem; color: var(--secondary-color);"><i class="fa <?= htmlspecialchars($item['icon']) ?>"></i></div>
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p><?= htmlspecialchars($item['desc']) ?></p>
            <h3><span class="badge"><?= htmlspecialchars($item['kpi']) ?></span></h3>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php?page=actions" class="btn">Veure Accions</a>
    </div>
</div>
