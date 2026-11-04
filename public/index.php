<?php 
require_once __DIR__ . '/../src/functions.php';
$employees = read_CSV(__DIR__ . '/../dataset/employees.csv');

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
           <?php if ($employees === []): ?>
                <p>Данные не найдены.</p>
            <?php else: ?>
                <table border="1" cellpadding="6">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Отдел</th>
                            <th>Стаж, лет</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $emp): ?>
                            <tr>
                                <td><?= e($emp['id']) ?></td>
                                <td><?= e($emp['name']) ?></td>
                                <td><?= e($emp['department']) ?></td>
                                <td><?= e($emp['experience']) ?></td>
                                <td><?= e($emp['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>
</body>