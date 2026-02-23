<div class="container section-title">
    <h2>Implementació i Cronograma</h2>
    <p>Temporalització detallada de la posada en marxa del Pla Digital.</p>
</div>

<div class="container">
    <div style="background: url('img/timeline.png') no-repeat left center; /* Mockup img */">
        <?php foreach ($implementation as $item): ?>
        <div class="timeline-item">
            <h3 style="color: var(--primary-color); display: flex; justify-content: space-between;">
                <?= htmlspecialchars($item['phase']) ?>
                <span style="font-size: 0.9rem; color: #888;"><?= htmlspecialchars($item['time']) ?></span>
            </h3>
            <p><strong>Tasques:</strong> <?= htmlspecialchars($item['tasks']) ?></p>
            <div style="margin-top: 10px; font-size: 0.9rem; color: #555;">
                <p><i class="fa fa-users"></i> <strong>Recursos:</strong> <?= htmlspecialchars($item['resources']) ?></p>
                <p><i class="fa fa-user-tie"></i> <strong>Responsable:</strong> <?= htmlspecialchars($item['manager']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php?page=monitoring" class="btn">Com es mesurarà l'èxit?</a>
    </div>
</div>
