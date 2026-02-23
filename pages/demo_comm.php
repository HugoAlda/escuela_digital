<?php
/** @var PDO $pdo */

$infoMessage = null;

// Signatura de circular
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sign_circular') {
    $circularId = (int) ($_POST['circular_id'] ?? 0);
    $familyName = trim($_POST['family_name'] ?? 'Família');

    if ($circularId > 0 && $familyName !== '') {
        $stmt = $pdo->prepare('INSERT INTO circular_signatures (circular_id, family_name) VALUES (:circular_id, :family_name)');
        $stmt->execute([
            ':circular_id' => $circularId,
            ':family_name' => $familyName,
        ]);
        $infoMessage = 'Circular signada digitalment.';
    }
}

// Nou missatge de xat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_message') {
    $content = trim($_POST['content'] ?? '');
    if ($content !== '') {
        $studentId = $pdo->query("SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1")->fetchColumn();
        $stmt = $pdo->prepare('INSERT INTO messages (student_id, sender_role, sender_name, content) VALUES (:student_id, :sender_role, :sender_name, :content)');
        $stmt->execute([
            ':student_id' => $studentId ?: null,
            ':sender_role' => 'familia',
            ':sender_name' => 'Família Garcia',
            ':content' => $content,
        ]);
    }
}

// Carregar circulars amb nombre de signatures
$circularsStmt = $pdo->query(
    'SELECT c.id, c.title, c.description, c.due_date,
            COUNT(s.id) AS signatures_count
     FROM circulars c
     LEFT JOIN circular_signatures s ON s.circular_id = c.id
     GROUP BY c.id
     ORDER BY c.due_date ASC'
);
$circulars = $circularsStmt->fetchAll();

// Carregar missatges de xat
$messagesStmt = $pdo->query(
    "SELECT sender_role, sender_name, content, created_at
     FROM messages
     ORDER BY created_at ASC
     LIMIT 50"
);
$messages = $messagesStmt->fetchAll();
?>

<div class="container section-title">
    <h2>Comunicació amb les Famílies</h2>
    <p>Circulars digitals i xat bàsic amb la tutora, guardats en base de dades.</p>
</div>

<div class="container" style="display: flex; gap: 30px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 300px;">
        <div class="card">
            <h3>Circulars digitals</h3>

            <?php if ($infoMessage): ?>
                <p style="padding: 8px 10px; border-radius: 5px; background: #e8f9f1; color: #1e824c; font-size: 0.9rem; font-weight: 500;">
                    <?= htmlspecialchars($infoMessage) ?>
                </p>
            <?php endif; ?>

            <div style="margin-top: 15px;">
                <?php foreach ($circulars as $c): ?>
                    <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                        <h4 style="margin: 0;"><?= htmlspecialchars($c['title']) ?></h4>
                        <?php if ($c['due_date']): ?>
                            <p style="font-size: 0.9rem; color: #666;">
                                Data límit: <?= htmlspecialchars($c['due_date']) ?>
                            </p>
                        <?php endif; ?>
                        <p style="font-size: 0.9rem; color: #555;"><?= htmlspecialchars($c['description']) ?></p>
                        <p style="font-size: 0.8rem; color: #888;">
                            Signatures rebudes: <?= (int) $c['signatures_count'] ?>
                        </p>
                        <form method="post" style="margin-top: 5px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <input type="hidden" name="action" value="sign_circular">
                            <input type="hidden" name="circular_id" value="<?= (int) $c['id'] ?>">
                            <input type="text" name="family_name" value="Família Garcia" style="flex: 1; min-width: 140px; padding: 6px 8px; border-radius: 5px; border: 1px solid #ddd; font-size: 0.85rem;">
                            <button class="btn" style="padding: 5px 15px; font-size: 0.8rem; margin-top: 5px;">Signar Digitalment</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div style="flex: 1; min-width: 300px;">
        <div class="card">
            <h3>Xat amb la Tutora (Maria)</h3>
            <div style="height: 240px; background: #f4f7f6; padding: 10px; border-radius: 5px; overflow-y: auto; margin-bottom: 15px;">
                <?php foreach ($messages as $msg): ?>
                    <?php if ($msg['sender_role'] === 'familia'): ?>
                        <div style="background: white; padding: 10px; border-radius: 10px 10px 10px 0; max-width: 80%; margin-bottom: 10px;">
                            <?= htmlspecialchars($msg['content']) ?>
                        </div>
                    <?php else: ?>
                        <div style="background: var(--primary-color); color: white; padding: 10px; border-radius: 10px 10px 0 10px; max-width: 80%; margin-left: auto; text-align: right;">
                            <?= htmlspecialchars($msg['content']) ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <form method="post" style="display: flex; gap: 10px;">
                <input type="hidden" name="action" value="send_message">
                <input type="text" name="content" placeholder="Escriu un missatge..." required style="flex: 1; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <button class="btn" style="margin: 0; padding: 10px 20px;"><i class="fa fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<div class="container text-center mt-4">
    <a href="index.php?page=demo" class="btn" style="background: #ddd; color: #333;">Tornar al panell</a>
</div>
