<?php
/** @var PDO $pdo */

$studentId = $pdo->query("SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1")->fetchColumn();

$docsStmt = $pdo->prepare(
    'SELECT name, file_type, size_label, category, created_at
     FROM documents
     WHERE student_id = :student_id
     ORDER BY created_at DESC'
);
$docsStmt->execute([':student_id' => $studentId]);
$documents = $docsStmt->fetchAll();

$requestMessage = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'request_document') {
    $docType = trim($_POST['doc_type'] ?? '');
    if ($docType !== '') {
        // En una app real, aquí es crearia una sol·licitud a BD.
        $requestMessage = 'Sol·licitud enviada correctament. El centre prepararà el document i l\'enviarà per correu.';
    }
}
?>

<div class="container section-title">
    <h2>Gestió Documental</h2>
    <p>Catàleg de documents acadèmics d'un alumne, basat en metadades en base de dades.</p>
</div>

<div class="container">
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <h3>Expedient Acadèmic - Marc Garcia (ESO-1A)</h3>
        <p style="color: #666; font-size: 0.9rem;">
            Darrera actualització:
            <?= $documents ? htmlspecialchars($documents[0]['created_at']) : date('Y-m-d') ?>
        </p>
        
        <div style="margin-top: 20px;">
            <?php foreach ($documents as $doc): ?>
                <div style="padding: 15px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <?php
                        $icon = 'fa-file';
                        $color = '#3498db';
                        if ($doc['file_type'] === 'pdf') {
                            $icon = 'fa-file-pdf';
                            $color = '#e74c3c';
                        } elseif ($doc['file_type'] === 'jpg' || $doc['file_type'] === 'png') {
                            $icon = 'fa-file-image';
                            $color = '#f1c40f';
                        }
                        ?>
                        <i class="fa <?= $icon ?>" style="font-size: 2rem; color: <?= $color ?>;"></i>
                        <div>
                            <h4 style="margin: 0;"><?= htmlspecialchars($doc['name']) ?></h4>
                            <span style="font-size: 0.8rem; color: #888;">
                                <?= strtoupper(htmlspecialchars($doc['file_type'])) ?>
                                <?php if ($doc['size_label']): ?>
                                    - <?= htmlspecialchars($doc['size_label']) ?>
                                <?php endif; ?>
                            </span>
                            <?php if ($doc['category']): ?>
                                <div style="font-size: 0.8rem; color: #777; margin-top: 4px;">
                                    Categoria: <?= htmlspecialchars($doc['category']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="btn"
                        onclick="alert('En un entorn real es descarregaria el fitxer <?= htmlspecialchars($doc['name']) ?>. Aquí es tracta d\'una mostra sense arxiu físic.');"
                        style="margin: 0; padding: 5px 15px; font-size: 0.8rem;"
                    >
                        <i class="fa fa-download"></i> Descarregar
                    </button>
                </div>
            <?php endforeach; ?>

            <?php if (!$documents): ?>
                <p>No hi ha documents registrats per aquest alumne.</p>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 25px; padding-top: 20px; border-top: 2px solid #ddd;">
            <h4>Sol·licitar Nou Document</h4>

            <?php if ($requestMessage): ?>
                <p style="padding: 8px 10px; border-radius: 5px; background: #e8f9f1; color: #1e824c; font-size: 0.9rem; font-weight: 500;">
                    <?= htmlspecialchars($requestMessage) ?>
                </p>
            <?php endif; ?>

            <form method="post" style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;">
                <input type="hidden" name="action" value="request_document">
                <select name="doc_type" style="flex: 1; padding: 10px; border-radius: 5px; border: 1px solid #ddd; min-width: 220px;" required>
                    <option value="">-- Selecciona un tipus de document --</option>
                    <option value="certificat_academic">Certificat Acadèmic Oficial</option>
                    <option value="justificant_matricula">Justificant de Matrícula</option>
                    <option value="asseguranca_escolar">Còpia Assegurança Escolar</option>
                </select>
                <button class="btn" style="margin: 0;">Sol·licitar</button>
            </form>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php?page=demo" class="btn" style="background: #ddd; color: #333;">Tornar al panell</a>
    </div>
</div>
