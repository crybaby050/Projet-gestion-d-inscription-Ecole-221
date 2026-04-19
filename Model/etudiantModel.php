<?php 
    require_once __DIR__ . '/communeModel.php';
    $etudiants = $data['etudiants'];

function saveEtudiant(array $etudiants) {
    $path = __DIR__ . '/../Data/data.json';
    $data = ['etudiants' => $etudiants];
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json);
}

function mailUnique(string $mail, array $etudiants): bool {
    foreach ($etudiants as $etudiant) {
        if ($etudiant['mail'] === $mail) {
            return true;
        }
    }
    return false;
}

function validerEmail(string $email): bool {
    $email = trim($email);
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $email) === 1;
}

function newId(array $etudiants): int {
    $maxId = 0;
    foreach ($etudiants as $etudiant) {
        if ($etudiant['id'] > $maxId) {
            $maxId = $etudiant['id'];
        }
    }
    return $maxId + 1;
}

function saisieEtudiant(array $etudiants): array {
    $nom = readline("Entrer le nom de l'etudiant : ");
    $pre = readline("Entrer le prenom de l'etudiant : ");

    do {
        $mail = readline("Entrer l'adresse mail de l'etudiant : ");
        if (!validerEmail($mail)) {
            echo "L'adresse mail que vous avez saisie est invalide\n";
        } elseif (mailUnique($mail, $etudiants)) {
            echo "L'adresse mail existe déjà\n";
        }
    } while (!validerEmail($mail) || mailUnique($mail, $etudiants));

    return ['nom' => $nom, 'pre' => $pre, 'mail' => $mail];
}

function ajoutEtudiant(array $etds, array $etudiants): array {
    $newEtudiant = [
        "id"     => newId($etudiants),
        "nom"    => $etds['nom'],
        "prenom" => $etds['pre'],
        "mail"   => $etds['mail']
    ];
    $etudiants[] = $newEtudiant;
    saveEtudiant($etudiants);
    return $newEtudiant;
}

function afficheTousLesEtudiants(array $etudiants): void {
    if (empty($etudiants)) {
        echo "\n  Aucun etudiant enregistre.\n";
        return;
    }
    echo "\n";
    echo "------------------------------------\n";
    foreach ($etudiants as $e) {
        echo "ID        : " . $e['id'] . "\n";
        echo "Nom       : " . $e['nom'] . "\n";
        echo "Prenom    : " . $e['prenom'] . "\n";
        echo "Email     : " . $e['mail'] . "\n";
        echo "Telephone : " . ($e['telephone'] ?? 'Non renseigne') . "\n";
        echo "------------------------------------\n";
    }
    echo "\n";
}

function rechercherEtudiantParId(int $id, array $etudiants): ?array {
    foreach ($etudiants as $etudiant) {
        if ($etudiant['id'] === $id) {
            return $etudiant;
        }
    }
    return null;
}
?>