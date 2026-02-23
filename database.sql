CREATE DATABASE IF NOT EXISTS `escuela_digital` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `escuela_digital`;

-- Estructura acadèmica: curs -> classe -> alumne
CREATE TABLE IF NOT EXISTS `courses` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,        -- p.ex. 3r Primària, 1r ESO
    `stage` VARCHAR(50) NOT NULL,        -- p.ex. Primària, ESO
    `sort_order` INT NOT NULL DEFAULT 0,
    UNIQUE KEY `uk_course_name` (`name`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `classrooms` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `course_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(50) NOT NULL,         -- p.ex. A, B, 1A
    `sort_order` INT NOT NULL DEFAULT 0,
    UNIQUE KEY `uk_course_class` (`course_id`, `name`),
    CONSTRAINT `fk_classroom_course` FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `students` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(150) NOT NULL,
    `classroom_id` INT UNSIGNED NOT NULL,
    `allergies` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_student_classroom` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO `courses` (`name`, `stage`, `sort_order`)
VALUES
('3r Primària', 'Primària', 30),
('1r ESO', 'ESO', 10);

INSERT INTO `classrooms` (`course_id`, `name`, `sort_order`)
VALUES
((SELECT id FROM courses WHERE name = '3r Primària' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '1r ESO' LIMIT 1), 'A', 1);

INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`)
VALUES
('Marc Garcia', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id WHERE co.name = '3r Primària' AND cl.name = 'A' LIMIT 1), 'Fruits secs'),
('Laia Garcia', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id WHERE co.name = '1r ESO' AND cl.name = 'A' LIMIT 1), NULL);

-- Cursos addicionals de mostra
INSERT IGNORE INTO `courses` (`name`, `stage`, `sort_order`) VALUES
('1r Primària', 'Primària', 10),
('2n Primària', 'Primària', 20),
('4t Primària', 'Primària', 40),
('5è Primària', 'Primària', 50),
('6è Primària', 'Primària', 60),
('2n ESO', 'ESO', 120),
('3r ESO', 'ESO', 130),
('4t ESO', 'ESO', 140);

-- Classes A i B per a cada curs (si no existeixen)
INSERT IGNORE INTO `classrooms` (`course_id`, `name`, `sort_order`) VALUES
((SELECT id FROM courses WHERE name = '1r Primària' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '1r Primària' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '2n Primària' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '2n Primària' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '3r Primària' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '4t Primària' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '4t Primària' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '5è Primària' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '5è Primària' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '6è Primària' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '6è Primària' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '1r ESO' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '2n ESO' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '2n ESO' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '3r ESO' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '3r ESO' LIMIT 1), 'B', 2),
((SELECT id FROM courses WHERE name = '4t ESO' LIMIT 1), 'A', 1),
((SELECT id FROM courses WHERE name = '4t ESO' LIMIT 1), 'B', 2);

-- Alumnes de mostra repartits per cursos i classes

-- 1r Primària A i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Anna Puig (1P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Marc Soler (1P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r Primària' AND cl.name = 'A' LIMIT 1), 'Làctics'),
('Laia Roca (1P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Pau Serra (1P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r Primària' AND cl.name = 'B' LIMIT 1), 'Fruits secs'),
('Iris Vidal (1P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Nil Costa (1P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r Primària' AND cl.name = 'B' LIMIT 1), NULL);

-- 2n Primària A i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Jordi Planas (2P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Carla Bosch (2P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n Primària' AND cl.name = 'A' LIMIT 1), 'Gluten'),
('Nora Pons (2P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Eric Vidal (2P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Marta Ferrer (2P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n Primària' AND cl.name = 'B' LIMIT 1), 'Ou'),
('Joel Valls (2P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n Primària' AND cl.name = 'B' LIMIT 1), NULL);

-- 3r Primària A (afegint a en Marc) i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Júlia Font (3P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Roger Martí (3P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r Primària' AND cl.name = 'A' LIMIT 1), 'Gluten'),
('Arnau Serra (3P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Maria Vidal (3P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Joan Riera (3P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r Primària' AND cl.name = 'B' LIMIT 1), 'Fruits secs');

-- 4t Primària A i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Bruna Serra (4P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Pere Bosch (4P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Helena Solé (4P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t Primària' AND cl.name = 'A' LIMIT 1), 'Làctics'),
('David Costa (4P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Paula Grau (4P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Nil Martí (4P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t Primària' AND cl.name = 'B' LIMIT 1), 'Peix');

-- 5è Primària A i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Aina Coll (5P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '5è Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Hugo Vidal (5P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '5è Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Marina Dalmau (5P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '5è Primària' AND cl.name = 'A' LIMIT 1), 'Fruits secs'),
('Sergi Clarà (5P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '5è Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Gina Pujol (5P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '5è Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Raül Casas (5P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '5è Primària' AND cl.name = 'B' LIMIT 1), 'Ou');

-- 6è Primària A i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Marta Rius (6P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '6è Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Jan Reig (6P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '6è Primària' AND cl.name = 'A' LIMIT 1), 'Làctics'),
('Carla Serra (6P-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '6è Primària' AND cl.name = 'A' LIMIT 1), NULL),
('Roger Vila (6P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '6è Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Noa López (6P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '6è Primària' AND cl.name = 'B' LIMIT 1), NULL),
('Arnau Vives (6P-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '6è Primària' AND cl.name = 'B' LIMIT 1), 'Gluten');

-- 1r ESO A i B (afegint a la Laia)
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Jan Pérez (1ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r ESO' AND cl.name = 'A' LIMIT 1), 'Ou'),
('Núria Casals (1ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Adrià López (1ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r ESO' AND cl.name = 'B' LIMIT 1), NULL),
('Maria Dalmau (1ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r ESO' AND cl.name = 'B' LIMIT 1), 'Peix'),
('Oriol Vila (1ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '1r ESO' AND cl.name = 'B' LIMIT 1), NULL);

-- 2n, 3r i 4t ESO A i B
INSERT INTO `students` (`full_name`, `classroom_id`, `allergies`) VALUES
('Laura Pons (2ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Pol Riba (2ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Hèctor Puig (2ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n ESO' AND cl.name = 'B' LIMIT 1), 'Làctics'),
('Ivet Mas (2ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '2n ESO' AND cl.name = 'B' LIMIT 1), NULL),
('Clàudia Soler (3ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Arnau Serra (3ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Lluc Costa (3ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r ESO' AND cl.name = 'B' LIMIT 1), 'Fruits secs'),
('Marta Casals (3ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '3r ESO' AND cl.name = 'B' LIMIT 1), NULL),
('Pau Vidal (4ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Gemma Roca (4ESO-A)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t ESO' AND cl.name = 'A' LIMIT 1), NULL),
('Joel Martí (4ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t ESO' AND cl.name = 'B' LIMIT 1), 'Gluten'),
('Sara Bosch (4ESO-B)', (SELECT cl.id FROM classrooms cl JOIN courses co ON co.id = cl.course_id
  WHERE co.name = '4t ESO' AND cl.name = 'B' LIMIT 1), NULL);

-- Taula de tiquets de menjador
CREATE TABLE IF NOT EXISTS `canteen_tickets` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    `menu_description` TEXT NOT NULL,
    `price` DECIMAL(6,2) NOT NULL DEFAULT 6.50,
    `status` ENUM('comprat','utilitzat','anul·lat') NOT NULL DEFAULT 'comprat',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_canteen_student` FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Taula de circulars
CREATE TABLE IF NOT EXISTS `circulars` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT NOT NULL,
    `due_date` DATE DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO `circulars` (`title`, `description`, `due_date`)
VALUES
('Autorització Sortida Zoo', 'Cal signar l''autorització per a la sortida al Zoo.', '2026-02-25'),
('Reunió de Pares (Meet)', 'Convocatòria de reunió virtual amb les famílies.', '2026-03-01');

-- Signatures de circulars (simple, sense autenticació real)
CREATE TABLE IF NOT EXISTS `circular_signatures` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `circular_id` INT UNSIGNED NOT NULL,
    `family_name` VARCHAR(150) NOT NULL,
    `signed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_signature_circular` FOREIGN KEY (`circular_id`) REFERENCES `circulars`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Missatges de xat amb la tutora
CREATE TABLE IF NOT EXISTS `messages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT UNSIGNED NULL,
    `sender_role` ENUM('familia','tutora') NOT NULL,
    `sender_name` VARCHAR(150) NOT NULL,
    `content` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_message_student` FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO `messages` (`student_id`, `sender_role`, `sender_name`, `content`)
VALUES
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'familia', 'Família Garcia', 'Hola, el Marc ha tingut una mica de febre avui.'),
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'tutora', 'Maria (Tutora)', 'Gràcies per avisar. Si empitjora, feu-nos-ho saber.');

-- Notes acadèmiques
CREATE TABLE IF NOT EXISTS `grades` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT UNSIGNED NOT NULL,
    `subject` VARCHAR(100) NOT NULL,
    `term` VARCHAR(50) NOT NULL,
    `exam_grade` DECIMAL(4,2) NOT NULL,
    `work_grade` DECIMAL(4,2) NOT NULL,
    `average_grade` DECIMAL(4,2) NOT NULL,
    `status` ENUM('aprovada','excel·lent','pendent') NOT NULL DEFAULT 'aprovada',
    CONSTRAINT `fk_grade_student` FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `grades` (`student_id`, `subject`, `term`, `exam_grade`, `work_grade`, `average_grade`, `status`)
VALUES
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'Matemàtiques', '2n Trimestre 2025-2026', 8.5, 9.0, 8.8, 'aprovada'),
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'Llengua Catalana', '2n Trimestre 2025-2026', 7.0, 6.5, 6.8, 'aprovada'),
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'Anglès', '2n Trimestre 2025-2026', 9.5, 10.0, 9.8, 'excel·lent');

-- Absències
CREATE TABLE IF NOT EXISTS `absences` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    `full_day` TINYINT(1) NOT NULL DEFAULT 1,
    `reason` VARCHAR(255) DEFAULT NULL,
    `justified` TINYINT(1) NOT NULL DEFAULT 0,
    `justification_text` TEXT DEFAULT NULL,
    CONSTRAINT `fk_absence_student` FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `absences` (`student_id`, `date`, `full_day`, `reason`, `justified`)
VALUES
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), '2026-02-15', 1, 'Gripe', 1);

-- Documents acadèmics (només metadades, no arxius reals)
CREATE TABLE IF NOT EXISTS `documents` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `file_type` VARCHAR(20) NOT NULL,
    `size_label` VARCHAR(50) DEFAULT NULL,
    `category` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_document_student` FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO `documents` (`student_id`, `name`, `file_type`, `size_label`, `category`)
VALUES
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'Butlletí Notes 1r Trimestre (2025-26)', 'pdf', '2.5 MB', 'Notes'),
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'Certificat de Matrícula (2025-26)', 'pdf', '1.2 MB', 'Certificat'),
((SELECT id FROM students WHERE full_name = 'Marc Garcia' LIMIT 1), 'Foto de l''Orla (Curs Passat)', 'jpg', '5.0 MB', 'Imatge');

