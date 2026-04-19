<?php
require_once __DIR__ . '/communeModel.php';

$formations = $data['formations'];

function saveFormation(array $formations): void {
    $data = jsonToArray();
    $data['formations'] = $formations;
    arrayToJson($data);
}

function titreUnique(string $titre, array $formations): bool {
    foreach ($formations as $formation) {
        if (strtolower($formation['titre']) === strtolower($titre)) {
            return true;
        }
    }
    return false;
}

function newIdFormation(array $formations): int {
    $maxId = 0;
    foreach ($formations as $formation) {
        if ($formation['id'] > $maxId) {
            $maxId = $formation['id'];
        }
    }
    return $maxId + 1;
}