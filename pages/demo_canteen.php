<?php
/** @var PDO $pdo */

// Resposta JSON per desplegables encadenats (AJAX)
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json; charset=utf-8');

    if ($_GET['ajax'] === 'classrooms') {
        $courseId = (int) ($_GET['course_id'] ?? 0);
        $stmt = $pdo->prepare('SELECT id, name FROM classrooms WHERE course_id = :course_id ORDER BY sort_order, name');
        $stmt->execute([':course_id' => $courseId]);
        echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($_GET['ajax'] === 'students') {
        $classroomId = (int) ($_GET['classroom_id'] ?? 0);
        $stmt = $pdo->prepare('SELECT id, full_name FROM students WHERE classroom_id = :classroom_id ORDER BY full_name');
        $stmt->execute([':classroom_id' => $classroomId]);
        echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}

// Carregar cursos (primer desplegable)
$coursesStmt = $pdo->query('SELECT id, name, stage FROM courses ORDER BY sort_order, name');
$courses = $coursesStmt->fetchAll();

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'buy_ticket') {
    $studentId = isset($_POST['student_id']) ? (int) $_POST['student_id'] : 0;
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';

    if ($studentId > 0 && $date !== '') {
        // Validar que l'alumne existeix
        $existsStmt = $pdo->prepare('SELECT COUNT(*) FROM students WHERE id = :id');
        $existsStmt->execute([':id' => $studentId]);
        if ((int) $existsStmt->fetchColumn() !== 1) {
            $message = 'Alumne no vàlid.';
        } else {
        $menuDescription = "Menú escolar estàndard (primer, segon i postres)";
        $stmt = $pdo->prepare('INSERT INTO canteen_tickets (student_id, date, menu_description) VALUES (:student_id, :date, :menu_description)');
        $stmt->execute([
            ':student_id' => $studentId,
            ':date' => $date,
            ':menu_description' => $menuDescription,
        ]);
        $message = 'Tiquet comprat correctament i registrat a la base de dades.';
        }
    } else {
        $message = 'Cal escollir un alumne i una data vàlida.';
    }
}

// Últims tiquets
$ticketsStmt = $pdo->query(
    'SELECT ct.date, ct.menu_description, ct.price, ct.status,
            s.full_name,
            co.name AS course_name,
            cl.name AS classroom_name
     FROM canteen_tickets ct
     JOIN students s ON s.id = ct.student_id
     JOIN classrooms cl ON cl.id = s.classroom_id
     JOIN courses co ON co.id = cl.course_id
     ORDER BY ct.created_at DESC
     LIMIT 10'
);
$tickets = $ticketsStmt->fetchAll();
?>

<div class="container section-title">
    <h2>Gestió del Menjador</h2>
    <p>Compra real de tiquets de menjador registrada en base de dades.</p>
</div>

<div class="container">
    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <h3>Compra de Tiquets</h3>
        <p>Seleccioneu el curs, la classe i l'alumne abans de comprar el tiquet.</p>

        <?php if ($message): ?>
            <p style="padding: 10px; border-radius: 5px; background: #e8f9f1; color: #1e824c; font-weight: 500;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>
        
        <form method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="action" value="buy_ticket">

            <label for="course_id">Curs:</label>
            <select name="course_id" id="course_id" required style="padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="">-- Selecciona un curs --</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= (int) $course['id'] ?>">
                        <?= htmlspecialchars($course['name']) ?> (<?= htmlspecialchars($course['stage']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="classroom_id">Classe:</label>
            <select name="classroom_id" id="classroom_id" required disabled style="padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="">-- Selecciona un curs primer --</option>
            </select>

            <label for="student_id">Alumne:</label>
            <select name="student_id" id="student_id" required disabled style="padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="">-- Selecciona una classe primer --</option>
            </select>
            
            <label for="date">Data:</label>
            <input type="date" name="date" id="date" required style="padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
            
            <div style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
                <h4 style="margin-top:0;">Menú del dia (exemple):</h4>
                <ul style="padding-left: 20px;">
                    <li>Primer: Macarrons a la bolonyesa</li>
                    <li>Segon: Pollastre al forn amb patates</li>
                    <li>Postres: Fruita del temps</li>
                </ul>
            </div>
            
            <button type="submit" class="btn" style="width: 100%;">Comprar Tiquet (6,50€)</button>
        </form>

        <script>
            const courseSelect = document.getElementById('course_id');
            const classroomSelect = document.getElementById('classroom_id');
            const studentSelect = document.getElementById('student_id');

            function setOptions(select, options, placeholder) {
                select.innerHTML = '';
                const ph = document.createElement('option');
                ph.value = '';
                ph.textContent = placeholder;
                select.appendChild(ph);
                options.forEach((opt) => {
                    const o = document.createElement('option');
                    o.value = opt.id;
                    o.textContent = opt.name || opt.full_name || '';
                    select.appendChild(o);
                });
            }

            courseSelect.addEventListener('change', async () => {
                const courseId = courseSelect.value;
                setOptions(classroomSelect, [], '-- Carregant classes... --');
                classroomSelect.disabled = true;
                setOptions(studentSelect, [], '-- Selecciona una classe primer --');
                studentSelect.disabled = true;

                if (!courseId) {
                    setOptions(classroomSelect, [], '-- Selecciona un curs primer --');
                    return;
                }

                const res = await fetch(`index.php?page=demo_canteen&ajax=classrooms&course_id=${encodeURIComponent(courseId)}`);
                const data = await res.json();
                setOptions(classroomSelect, data, '-- Selecciona una classe --');
                classroomSelect.disabled = false;
            });

            classroomSelect.addEventListener('change', async () => {
                const classroomId = classroomSelect.value;
                setOptions(studentSelect, [], '-- Carregant alumnes... --');
                studentSelect.disabled = true;

                if (!classroomId) {
                    setOptions(studentSelect, [], '-- Selecciona una classe primer --');
                    return;
                }

                const res = await fetch(`index.php?page=demo_canteen&ajax=students&classroom_id=${encodeURIComponent(classroomId)}`);
                const data = await res.json();
                // Re-map perquè setOptions utilitzi "name"
                const students = data.map(s => ({ id: s.id, name: s.full_name }));
                setOptions(studentSelect, students, '-- Selecciona un alumne --');
                studentSelect.disabled = false;
            });
        </script>
    </div>

    <div class="card" style="max-width: 900px; margin: 40px auto 0;">
        <h3>Tiquets recents</h3>
        <?php if (!$tickets): ?>
            <p>Encara no hi ha tiquets registrats.</p>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                    <thead>
                        <tr style="border-bottom: 2px solid #eee;">
                            <th style="text-align: left; padding: 8px;">Alumne</th>
                            <th style="text-align: left; padding: 8px;">Grup</th>
                            <th style="text-align: left; padding: 8px;">Data</th>
                            <th style="text-align: left; padding: 8px;">Menú</th>
                            <th style="text-align: center; padding: 8px;">Preu</th>
                            <th style="text-align: center; padding: 8px;">Estat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr style="border-bottom: 1px solid #f0f0f0;">
                                <td style="padding: 8px;"><?= htmlspecialchars($ticket['full_name']) ?></td>
                                <td style="padding: 8px;">
                                    <?= htmlspecialchars($ticket['course_name']) ?> <?= htmlspecialchars($ticket['classroom_name']) ?>
                                </td>
                                <td style="padding: 8px;"><?= htmlspecialchars($ticket['date']) ?></td>
                                <td style="padding: 8px;"><?= htmlspecialchars($ticket['menu_description']) ?></td>
                                <td style="padding: 8px; text-align: center;"><?= number_format((float) $ticket['price'], 2, ',', '.') ?> €</td>
                                <td style="padding: 8px; text-align: center; text-transform: capitalize;"><?= htmlspecialchars($ticket['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php?page=demo" class="btn" style="background: #ddd; color: #333;">Tornar al panell</a>
    </div>
</div>
