<?php 
declare(strict_types=1);

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function read_CSV(string $path): array {
    if (!is_readable($path)){
        return [];
    }

    $handle = fopen($path, 'r');
    $header = fgetcsv($handle, 0, ';');
    $header[0] = ltrim($header[0], "\xEF\xBB\xBF"); 

    $employees = [];
    while (($row = fgetcsv($handle, 0, ';')) !== false){
        if ($row === [null]){
            continue;
        }
        $employees[] = parseEmployeesRow($header, $row);
    }
    fclose($handle);

    return $employees;
}

function parseEmployeesRow(array $header, array $row): array {
    $data = array_combine($header, $row);

    return [
        'id'         => (int) $data['id'],
        'name'       => trim($data['name']),
        'department' => trim($data['department']),
        'experience' => (int) $data['experience'],
        'email'      => trim($data['email']),
    ];
}

function validateInput(array $input): array {
    $experience = $input['experience'] ?? '';

    $errors = [];
    if ($input['name'] === ''){
        $errors['name'] = 'Укажите ФИО';
    } elseif (iconv_strlen($input['name']) < 2 || iconv_strlen($input['name']) > 100) {
        $errors['name'] = 'ФИО должно содержать от 2 до 100 символов';
    }

    if ($input['email'] === ''){
        $errors['email'] = 'Укажите email';
    } elseif (filter_var($input['email'], FILTER_VALIDATE_EMAIL) === false){
        $errors['email'] = 'Email должен быть в формате email@email.email';
    }

    if ($input['department'] === ''){
        $errors['department'] = 'Укажите отдел';
    }

    if ($experience === '') {
        $errors['experience'] = 'Укажите стаж';
    } elseif (filter_var($experience, FILTER_VALIDATE_INT) === false) {
        $errors['experience'] = 'Стаж должен быть целым числом';
    } elseif ((int) $experience < 0 || (int) $experience > 50) {
        $errors['experience'] = 'Стаж должен быть от 0 до 50 лет';
    }

    return $errors;
}

function filterByDepartment(array $employees, string $department): array{
    if ($department === ''){
        return $employees;
    }

    return array_values(array_filter(
        $employees,
        fn(array $emp): bool => $emp['department'] === $department
    ));
}