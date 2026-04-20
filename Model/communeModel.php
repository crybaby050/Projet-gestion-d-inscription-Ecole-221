<?php
function jsonToArray(): array {
    $path = __DIR__ . '/../Data/data.json';
    if (!file_exists($path)) {
        return ['etudiants' => [], 'formations' => []];
    }
    $json = file_get_contents($path);
    return json_decode($json, true);
}

function arrayToJson(array $array): bool {
    $path = __DIR__ . '/../Data/data.json';
    $json = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}

$data = jsonToArray();