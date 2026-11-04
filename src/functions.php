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
        $employees[] = array_combine($header, $row);
    }
    fclose($handle);

    return $employees;
}