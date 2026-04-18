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

function afficheToutLesEtudiants(array $etudiants): void {
    if (empty($etudiants)) {
        echo "Aucun étudiant enregistré.\n";
        return;
    }
    foreach ($etudiants as $etudiant) {
        echo "ID     : " . $etudiant['id'] . "\n";
        echo "Nom    : " . $etudiant['nom'] . "\n";
        echo "Prenom : " . $etudiant['prenom'] . "\n";
        echo "Mail   : " . $etudiant['mail'] . "\n";
        echo "----------------------------\n";
    }
}
/*
do {
    echo "\n=== MENU ===\n";
    echo "1 - Ajouter un étudiant\n";
    echo "2 - Afficher tous les étudiants\n";
    echo "0 - Quitter\n";

    $n = (int) readline("Faire un choix : ");

    if ($n == 1) {
        $etu = saisieEtudiant($etudiants);
        $nouveau = ajoutEtudiant($etu, $etudiants);
        $etudiants[] = $nouveau; // mise à jour du tableau en mémoire
        echo "Étudiant ajouté avec succès !\n";
    } elseif ($n == 2) {
        afficheToutLesEtudiants($etudiants);
    } elseif ($n != 0) {
        echo "Choix invalide, veuillez réessayer.\n";
    }

} while ($n != 0);
*/
//echo "Au revoir !\n";
?>