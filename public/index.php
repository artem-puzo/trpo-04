<?php 
const APP_VERSION = "1.0.0";

$appTitle = 'Заявки сотрудников';
$maxExperiance = 50;
$minExperiance = 0;
$showHint = true;
$departments   = ['Разработка', 'Аналитика', 'Тестирование', 'Поддержка'];
?>

<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset="UTF-8">
    <title><?= $appTitle ?></title>
</head>
<body>
    <header>
        <h1><?= $appTitle ?></h1>
        <p>Версия: <?= APP_VERSION ?> · Дата: <?= date('d.m.Y H:i') ?></p>
        <nav><a href="#employees">Сотрудники</a></nav>
    </header>   
    <main>
        <section id="employees">
            <h2>Сотрудники</h2>

            <?php if ($showHint): ?>
                <p>Максимальный стаж: <?= $maxExperiance ?> лет.</p>
            <?php endif; ?>
            
            <ul>
                <?php foreach ($departments as $dep): ?>
                    <li><?= $dep ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>