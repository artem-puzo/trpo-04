<?php 
require_once __DIR__ . '/../src/functions.php';
$employees = read_CSV(__DIR__ . '/../dataset/employees.csv');

$departments = array_unique(array_column($employees, 'department'));

$values  = ['name' => '', 'email' => '', 'department' => '', 'experience' => ''];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    foreach ($values as $field => $_){
        $values[$field] = trim($_POST[$field] ?? '');
    }
    $errors = validateInput($values);
    $success = $errors === [];
}

const APP_VERSION = "1.0.0";

$appTitle = 'Заявки сотрудников';
$maxExperiance = 50;
$minExperiance = 0;
$showHint = true;
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
        <nav>
            <a href="#employees">Сотрудники</a>
            <a href="#request">Новая заявка</a> 
        </nav>
    </header>   
    <main>
        <section id="request">
            <h2>Заявка сотрудника</h2>

            <?php if ($success): ?>
                <p><strong>Заявка принята:</strong>
                    <?= e($values['name']) ?>, <?= e($values['department']) ?>,
                    стаж <?= (int) $values['experience'] ?> лет, <?= e($values['email']) ?>.</p>
            <?php elseif ($errors !== []): ?>
                <div>
                    <p>Исправьте ошибки:</p>
                    <ul>
                        <?php foreach ($errors as $message): ?>
                            <li><?= e($message) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="#request" novalidate>
                <p>
                    <label for="name">ФИО</label><br>
                    <input type="text" id="name" name="name" value="<?= e($values['name']) ?>">
                    <?php if (isset($errors['name'])): ?>
                        <br><small style="color:red"><?= e($errors['name']) ?></small>
                    <?php endif; ?>
                </p>

                <p>
                    <label for="email">Email</label><br>
                    <input type="text" id="email" name="email" value="<?= e($values['email']) ?>">
                    <?php if (isset($errors['email'])): ?>
                        <br><small style="color:red"><?= e($errors['email']) ?></small>
                    <?php endif; ?>
                </p>

                <p>
                    <label for="department">Отдел</label><br>
                    <select id="department" name="department">
                        <option value="">— выберите —</option>
                        <?php foreach ($departments as $dep): ?>
                            <option value="<?= e($dep) ?>"<?= $values['department'] === $dep ? ' selected' : '' ?>>
                                <?= e($dep) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['department'])): ?>
                        <br><small style="color:red"><?= e($errors['department']) ?></small>
                    <?php endif; ?>
                </p>

                <p>
                    <label for="experience">Стаж, лет</label><br>
                    <input type="text" id="experience" name="experience" value="<?= e($values['experience']) ?>">
                    <?php if (isset($errors['experience'])): ?>
                        <br><small style="color:red"><?= e($errors['experience']) ?></small>
                    <?php endif; ?>
                </p>

                <button type="submit">Отправить</button>
            </form>
        </section>
    </main>
</body>