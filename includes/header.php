<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pla de Transformació Digital - Escola del Futur</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Extra inline styles for specific components if needed */
        .timeline-item {
            padding: 20px;
            border-left: 3px solid var(--primary-color);
            position: relative;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 0 10px 10px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            background: var(--primary-color);
            border-radius: 50%;
            left: -9px;
            top: 25px;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            background: var(--accent-color);
            color: white;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .metric-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .metric-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.php" class="logo">
                    <i class="fa-solid fa-graduation-cap"></i> Escola Digital
                </a>
                <ul class="nav-links">
                    <li><a href="index.php?page=home" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Inici</a></li>
                    <li><a href="index.php?page=demo_canteen" class="<?php echo ($page === 'demo_canteen') ? 'active' : ''; ?>">Menjador</a></li>
                    <li><a href="index.php?page=demo_comm" class="<?php echo ($page === 'demo_comm') ? 'active' : ''; ?>">Comunicació</a></li>
                    <li><a href="index.php?page=demo_academic" class="<?php echo ($page === 'demo_academic') ? 'active' : ''; ?>">Acadèmic</a></li>
                    <li><a href="index.php?page=demo_docs" class="<?php echo ($page === 'demo_docs') ? 'active' : ''; ?>">Documental</a></li>
                    <li><a href="index.php?page=demo" class="<?php echo ($page === 'demo') ? 'active' : ''; ?>" style="color: var(--accent-color); font-weight: 700;">Panell d'eines</a></li>
                </ul>
            </nav>
        </div>
    </header>
