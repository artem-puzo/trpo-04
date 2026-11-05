<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../src/functions.php';

$cases = json_decode(
    file_get_contents(__DIR__ . '/../dataset/form_cases.json'),
    true
);

foreach ($cases as $case) {
    $input = [
        'name'       => trim((string) $case['name']),
        'email'      => 'test@example.test',
        'department' => 'Разработка',
        'experience' => trim((string) $case['experience']),
    ];

    $isValid = validateInput($input) === [];
    $status  = $isValid === $case['valid'] ? 'OK' : 'FAIL';

    echo "[$status] {$case['case']}: ожидалось " . var_export($case['valid'], true)
        . ", получено " . var_export($isValid, true) . "\n";
}