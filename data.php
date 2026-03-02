<?php
/**
 * Dades estàtiques (sense base de dades)
 * Substitueix la connexió PDO per arrays amb dades de mostra.
 */

// ─── CURSOS ────────────────────────────────────────────────────────────────
$COURSES = [
    ['id' => 1, 'name' => '1r ESO',  'stage' => 'Secundària'],
    ['id' => 2, 'name' => '2n ESO',  'stage' => 'Secundària'],
    ['id' => 3, 'name' => '3r ESO',  'stage' => 'Secundària'],
    ['id' => 4, 'name' => '6è Primària', 'stage' => 'Primària'],
];

// ─── CLASSES ────────────────────────────────────────────────────────────────
$CLASSROOMS = [
    ['id' => 1, 'name' => 'A', 'course_id' => 1],
    ['id' => 2, 'name' => 'B', 'course_id' => 1],
    ['id' => 3, 'name' => 'A', 'course_id' => 2],
    ['id' => 4, 'name' => 'B', 'course_id' => 2],
    ['id' => 5, 'name' => 'A', 'course_id' => 3],
    ['id' => 6, 'name' => 'A', 'course_id' => 4],
];

// ─── ALUMNES ────────────────────────────────────────────────────────────────
$STUDENTS = [
    ['id' => 1, 'full_name' => 'Marc Garcia',     'classroom_id' => 1],
    ['id' => 2, 'full_name' => 'Laura Martínez',  'classroom_id' => 1],
    ['id' => 3, 'full_name' => 'Pol López',        'classroom_id' => 1],
    ['id' => 4, 'full_name' => 'Júlia Puig',       'classroom_id' => 2],
    ['id' => 5, 'full_name' => 'Sergi Torres',     'classroom_id' => 2],
    ['id' => 6, 'full_name' => 'Marta Vidal',      'classroom_id' => 3],
    ['id' => 7, 'full_name' => 'Arnau Ferrer',     'classroom_id' => 3],
    ['id' => 8, 'full_name' => 'Laia Soler',       'classroom_id' => 4],
    ['id' => 9, 'full_name' => 'Oriol Bosch',      'classroom_id' => 5],
    ['id' => 10,'full_name' => 'Neus Casas',       'classroom_id' => 6],
];

// ─── TIQUETS DE MENJADOR ────────────────────────────────────────────────────
$CANTEEN_TICKETS = [
    ['full_name' => 'Marc Garcia',    'course_name' => '1r ESO', 'classroom_name' => 'A', 'date' => '2026-03-01', 'menu_description' => 'Menú escolar estàndard (primer, segon i postres)', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Laura Martínez', 'course_name' => '1r ESO', 'classroom_name' => 'A', 'date' => '2026-03-01', 'menu_description' => 'Menú vegetarià', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Pol López',      'course_name' => '1r ESO', 'classroom_name' => 'A', 'date' => '2026-02-28', 'menu_description' => 'Menú escolar estàndard (primer, segon i postres)', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Júlia Puig',     'course_name' => '1r ESO', 'classroom_name' => 'B', 'date' => '2026-02-28', 'menu_description' => 'Menú sense gluten', 'price' => 6.50, 'status' => 'pendent'],
    ['full_name' => 'Sergi Torres',   'course_name' => '1r ESO', 'classroom_name' => 'B', 'date' => '2026-02-27', 'menu_description' => 'Menú escolar estàndard (primer, segon i postres)', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Marta Vidal',    'course_name' => '2n ESO', 'classroom_name' => 'A', 'date' => '2026-02-27', 'menu_description' => 'Menú vegetarià', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Marc Garcia',    'course_name' => '1r ESO', 'classroom_name' => 'A', 'date' => '2026-02-26', 'menu_description' => 'Menú escolar estàndard (primer, segon i postres)', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Arnau Ferrer',   'course_name' => '2n ESO', 'classroom_name' => 'A', 'date' => '2026-02-26', 'menu_description' => 'Menú escolar estàndard (primer, segon i postres)', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Laia Soler',     'course_name' => '2n ESO', 'classroom_name' => 'B', 'date' => '2026-02-25', 'menu_description' => 'Menú sense lactosa', 'price' => 6.50, 'status' => 'pagat'],
    ['full_name' => 'Oriol Bosch',    'course_name' => '3r ESO', 'classroom_name' => 'A', 'date' => '2026-02-25', 'menu_description' => 'Menú escolar estàndard (primer, segon i postres)', 'price' => 6.50, 'status' => 'pendent'],
];

// ─── NOTES (alumne Marc Garcia) ─────────────────────────────────────────────
$GRADES = [
    ['subject' => 'Matemàtiques',      'term' => '2n Trimestre 2025-26', 'exam_grade' => 7.5, 'work_grade' => 8.0, 'average_grade' => 7.8, 'status' => 'aprovat'],
    ['subject' => 'Llengua Catalana',  'term' => '2n Trimestre 2025-26', 'exam_grade' => 9.0, 'work_grade' => 9.5, 'average_grade' => 9.2, 'status' => 'excel·lent'],
    ['subject' => 'Llengua Castellana','term' => '2n Trimestre 2025-26', 'exam_grade' => 8.0, 'work_grade' => 7.5, 'average_grade' => 7.7, 'status' => 'aprovat'],
    ['subject' => 'Anglès',            'term' => '2n Trimestre 2025-26', 'exam_grade' => 8.5, 'work_grade' => 9.0, 'average_grade' => 8.7, 'status' => 'excel·lent'],
    ['subject' => 'Ciències Naturals', 'term' => '2n Trimestre 2025-26', 'exam_grade' => 6.5, 'work_grade' => 7.0, 'average_grade' => 6.7, 'status' => 'aprovat'],
    ['subject' => 'Història',          'term' => '2n Trimestre 2025-26', 'exam_grade' => 7.0, 'work_grade' => 8.0, 'average_grade' => 7.4, 'status' => 'aprovat'],
    ['subject' => 'Educació Física',   'term' => '2n Trimestre 2025-26', 'exam_grade' => 9.0, 'work_grade' => 9.0, 'average_grade' => 9.0, 'status' => 'excel·lent'],
];

// ─── ABSÈNCIES (alumne Marc Garcia) ─────────────────────────────────────────
$ABSENCES = [
    ['id' => 1, 'date' => '2026-02-20', 'full_day' => true,  'reason' => 'Malaltia',       'justified' => true,  'justification_text' => 'Certificat mèdic aportat'],
    ['id' => 2, 'date' => '2026-02-14', 'full_day' => false, 'reason' => 'Visita mèdica',  'justified' => true,  'justification_text' => 'Resguard de la visita mèdica'],
    ['id' => 3, 'date' => '2026-01-30', 'full_day' => true,  'reason' => null,              'justified' => false, 'justification_text' => null],
    ['id' => 4, 'date' => '2026-01-22', 'full_day' => false, 'reason' => 'Activitat extraescolar', 'justified' => true, 'justification_text' => 'Competició esportiva oficial'],
    ['id' => 5, 'date' => '2026-01-10', 'full_day' => true,  'reason' => null,              'justified' => false, 'justification_text' => null],
];

// ─── CIRCULARS ───────────────────────────────────────────────────────────────
$CIRCULARS = [
    ['id' => 1, 'title' => 'Sortida cultural al Museu d\'Història', 'description' => 'El proper 15 de març visitarem el Museu d\'Història de Catalunya. Cal autorització familiar signada.', 'due_date' => '2026-03-10', 'signatures_count' => 18],
    ['id' => 2, 'title' => 'Reunió de pares i mares – 2n Trimestre', 'description' => 'Us convoquem a la reunió trimestral de famílies el dia 20 de març a les 18h a la sala d\'actes.', 'due_date' => '2026-03-18', 'signatures_count' => 12],
    ['id' => 3, 'title' => 'Pla d\'emergència escolar – actualització', 'description' => 'S\'ha actualitzat el protocol d\'emergència del centre. Llegiu el document adjunt i signeu la recepció.', 'due_date' => '2026-03-05', 'signatures_count' => 25],
];

// ─── MISSATGES DE XAT ────────────────────────────────────────────────────────
$MESSAGES = [
    ['sender_role' => 'tutora',  'sender_name' => 'Maria (Tutora)', 'content' => 'Bon dia, família Garcia! Aquest trimestre Marc va molt bé a Anglès i Educació Física. Continueu animant-lo!', 'created_at' => '2026-02-10 09:00:00'],
    ['sender_role' => 'familia', 'sender_name' => 'Família Garcia',  'content' => 'Moltes gràcies per la informació! Treballarem per millorar les Ciències Naturals.',                            'created_at' => '2026-02-10 09:15:00'],
    ['sender_role' => 'tutora',  'sender_name' => 'Maria (Tutora)', 'content' => 'Perfecte, qualsevol dubte no dubteu a escriure. Bon dia!',                                                      'created_at' => '2026-02-10 09:20:00'],
    ['sender_role' => 'familia', 'sender_name' => 'Família Garcia',  'content' => 'Volia preguntar sobre l\'absència del 30 de gener. Podeu indicar-nos com justificar-la?',                       'created_at' => '2026-02-20 17:30:00'],
    ['sender_role' => 'tutora',  'sender_name' => 'Maria (Tutora)', 'content' => 'Hola! Podeu justificar-la directament des de la secció Acadèmic → Absències. Gràcies!',                         'created_at' => '2026-02-20 17:45:00'],
];

// ─── DOCUMENTS (alumne Marc Garcia) ─────────────────────────────────────────
$DOCUMENTS = [
    ['name' => 'Butlletí de Notes – 1r Trimestre 2025-26', 'file_type' => 'pdf', 'size_label' => '124 KB', 'category' => 'Notes',       'created_at' => '2026-01-15'],
    ['name' => 'Certificat de Matrícula 2025-26',           'file_type' => 'pdf', 'size_label' => '89 KB',  'category' => 'Matrícula',   'created_at' => '2025-09-10'],
    ['name' => 'Fotografia carnet alumne',                  'file_type' => 'jpg', 'size_label' => '340 KB', 'category' => 'Identificació','created_at' => '2025-09-05'],
    ['name' => 'Autorització sortida Museu',                'file_type' => 'pdf', 'size_label' => '56 KB',  'category' => 'Autoritzacions','created_at' => '2026-02-28'],
    ['name' => 'Assegurança Escolar 2025-26',               'file_type' => 'pdf', 'size_label' => '210 KB', 'category' => 'Assegurança', 'created_at' => '2025-09-10'],
];
