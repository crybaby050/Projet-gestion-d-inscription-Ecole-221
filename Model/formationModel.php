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

function saisieFormation(array $formations): array {
    do {
        $titre = readline("Titre       : ");
        if (titreUnique($titre, $formations)) {
            echo "  Ce titre existe deja. Reessayez.\n";
        }
    } while (titreUnique($titre, $formations));

    $description = readline("Description : ");
    $duree       = intval(readline("Duree       : "));

    return [
        'titre'       => $titre,
        'description' => $description,
        'duree'       => $duree
    ];
}

function ajoutFormation(array $form, array $formations): void {
    $newFormation = [
        "id"          => newIdFormation($formations),
        "titre"       => $form['titre'],
        "description" => $form['description'],
        "duree"       => $form['duree']
    ];
    $formations[] = $newFormation;
    saveFormation($formations);
    echo "\n  Formation ajoutee avec succes ! (ID : " . $newFormation['id'] . ")\n";
}

function afficheToutesLesFormations(array $formations): void {
    if (empty($formations)) {
        echo "\n  Aucune formation enregistree.\n";
        return;
    }
    echo "\n";
    echo "------------------------------------\n";
    foreach ($formations as $f) {
        echo "ID          : " . $f['id'] . "\n";
        echo "Titre       : " . $f['titre'] . "\n";
        echo "Duree       : " . $f['duree'] . "\n";
        echo "Description : " . ($f['description'] ?? 'Non renseignee') . "\n";
        echo "------------------------------------\n";
    }
    echo "\n";
}

function rechercherFormationParId(int $id, array $formations): ?array {
    foreach ($formations as $formation) {
        if ($formation['id'] === $id) {
            return $formation;
        }
    }
    return null;
}

