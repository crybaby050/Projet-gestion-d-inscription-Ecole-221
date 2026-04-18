<?php
// fonction qui permet de transformer les données json en données php exploitables
function jsonToArray(){
    $path = __DIR__ . '/../Data/data.json';
    if (!file_exists($path)) {
        return ['users' => []];
    }
    $json = file_get_contents($path);
    return json_decode($json, true);
}

// fonction qui permet de transformer des données php en json
function arrayToJson($array){
    $path = __DIR__ . '/../Data/data.json';
    $tab = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $tab);
}