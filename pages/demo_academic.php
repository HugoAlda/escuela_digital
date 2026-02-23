<?php
/** @var PDO $pdo */

$studentId = $pdo->query("SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1")->fetchColumn();

// Notes del curs
$gradesStmt = $pdo->prepare(
    'SELECT subject, term, exam_grade, work_grade, average_grade, status
     FROM grades
     WHERE student_id = :student_id
     ORDER BY subject ASC'
);
$gradesStmt->execute([':student_id' => $studentId]);
$grades = $gradesStmt->fetchAll();

// Justificar absència
$feedback = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'justify_absence') {
    $absenceId = (int) ($_POST['absence_id'] ?? 0);
    $text = trim($_POST['justification_text'] ?? '');
    if ($absenceId > 0 && $text !== '') {
        $stmt = $pdo->prepare('UPDATE absences SET justified = 1, justification_text = :text WHERE id = :id');
        $stmt->execute([':text' => $text, ':id' => $absenceId]);
        $feedback = 'Absència justificada correctament.';
    }
}

// Absències
$absStmt = $pdo->prepare(
    'SELECT id, date, full_day, reason, justified, justification_text
     FROM absences
     WHERE student_id = :student_id
     ORDER BY date DESC
     LIMIT 10'
);
$absStmt->execute([':student_id' => $studentId]);
$absences = $absStmt->fetchAll();
?>

<div class="container section-title">
    <h2>Gestió Acadèmica</h2>
    <p>Consulta de notes i justificació d'absències, amb dades des de la base de dades.</p>
</div>

<div class="container">
    <div class="card" style="max-width: 800px; margin: 0 auto; overflow: hidden;">
        <h3>Notes Trimestrals - Marc Garcia</h3>
        <?php if (!empty($grades)): ?>
            <p style="color: #666; font-size: 0.9rem;">
                Curs / Període: <?= htmlspecialchars($grades[0]['term']) ?>
            </p>
        <?php endif; ?>
        
        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-top: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="text-align: left; padding: 10px;">Assignatura</th>
                        <th style="padding: 10px; text-align: center;">Examen</th>
                        <th style="padding: 10px; text-align: center;">Treball</th>
                        <th style="padding: 10px; text-align: center;">Mitjana</th>
                        <th style="padding: 10px; text-align: center;">Estat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $grade): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;"><?= htmlspecialchars($grade['subject']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($grade['exam_grade']) ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($grade['work_grade']) ?></td>
                            <td style="text-align: center; font-weight: bold;"><?= htmlspecialchars($grade['average_grade']) ?></td>
                            <td style="text-align: center;">
                                <?php if ($grade['status'] === 'excel·lent'): ?>
                                    <i class="fa fa-star" style="color: gold;"></i>
                                <?php else: ?>
                                    <i class="fa fa-check-circle" style="color: green;"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="card" style="margin-top: 30px; background: #fffcf5;">
            <h4><i class="fa fa-clock"></i> Absències recents</h4>

            <?php if ($feedback): ?>
                <p style="padding: 8px 10px; border-radius: 5px; background: #e8f9f1; color: #1e824c; font-size: 0.9rem; font-weight: 500;">
                    <?= htmlspecialchars($feedback) ?>
                </p>
            <?php endif; ?>

            <?php if (!$absences): ?>
                <p>No hi ha absències registrades.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <?php foreach ($absences as $absence): ?>
                        <li style="padding: 10px 0; border-bottom: 1px dashed #ddd; display: flex; flex-direction: column; gap: 6px;">
                            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                <span>
                                    <?= htmlspecialchars($absence['date']) ?>
                                    - <?= $absence['full_day'] ? 'Tot el dia' : 'Parcial' ?>
                                    <?php if ($absence['reason']): ?>
                                        - <?= htmlspecialchars($absence['reason']) ?>
                                    <?php endif; ?>
                                </span>
                                <span style="<?= $absence['justified'] ? 'color: green;' : 'color: #e67e22;' ?>">
                                    <?php if ($absence['justified']): ?>
                                        Justificat <i class="fa fa-check"></i>
                                    <?php else: ?>
                                        Pendent de justificació
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php if (!$absence['justified']): ?>
                                <form method="post" style="margin-top: 5px; display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                                    <input type="hidden" name="action" value="justify_absence">
                                    <input type="hidden" name="absence_id" value="<?= (int) $absence['id'] ?>">
                                    <input
                                        type="text"
                                        name="justification_text"
                                        required
                                        placeholder="Motiu de la justificació..."
                                        style="flex: 1; min-width: 180px; padding: 6px 8px; border-radius: 5px; border: 1px solid #ddd; font-size: 0.85rem;"
                                    >
                                    <button class="btn" style="padding: 6px 14px; font-size: 0.85rem; margin: 0;">Justificar Falta</button>
                                </form>
                            <?php elseif ($absence['justification_text']): ?>
                                <p style="font-size: 0.85rem; color: #555; margin: 0;">
                                    Justificació: <?= htmlspecialchars($absence['justification_text']) ?>
                                </p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php?page=demo" class="btn" style="background: #ddd; color: #333;">Tornar al panell</a>
    </div>
</div>
