<?php
/**
 * demo_comm.php – Comunicació amb les Famílies (dades estàtiques, sense BD)
 */

$infoMessage = null;

// Signatura de circular (simulada)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sign_circular') {
    $circularId = (int) ($_POST['circular_id'] ?? 0);
    $familyName = trim($_POST['family_name'] ?? 'Família');
    if ($circularId > 0 && $familyName !== '') {
        $infoMessage = 'Circular signada digitalment per ' . htmlspecialchars($familyName) . '.';
        // Incrementem el comptador de signatures en memòria per mostrar el canvi
        foreach ($CIRCULARS as &$c) {
            if ($c['id'] === $circularId) { $c['signatures_count']++; }
        }
        unset($c);
    }
}

// Nou missatge de xat (simulat: l'afegim a l'array en memòria)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_message') {
    $content = trim($_POST['content'] ?? '');
    if ($content !== '') {
        $MESSAGES[] = [
            'sender_role' => 'familia',
            'sender_name' => 'Família Garcia',
            'content'     => $content,
            'created_at'  => date('Y-m-d H:i:s'),
        ];
    }
}

$circulars = $CIRCULARS;
$messages  = array_slice($MESSAGES, 0, 50);
?>

<div class="container section-title">
    <h2>Comunicació amb les Famílies</h2>
    <p>Circulars digitals i xat bàsic amb la tutora.</p>
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
                        <div style="background: var(--primary-color); color: white; padding: 10px; border-radius: 10px 10px 0 10px; max-width: 80%; margin-left: auto; text-align: right; margin-bottom: 10px;">
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
