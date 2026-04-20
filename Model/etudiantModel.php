<?php
require_once __DIR__ . '/communeModel.php';

$etudiants = $data['etudiants'];

function saveEtudiant(array $etudiants): void {
    $data = jsonToArray();
    $data['etudiants'] = $etudiants;
    arrayToJson($data);
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

function validerTelephone(string $telephone): bool {
    $telephone = trim($telephone);
    $pattern = '/^(\+221|00221)?\s?(7[05678])\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}$/';
    return preg_match($pattern, $telephone) === 1;
}

function newIdEtudiant(array $etudiants): int {
    $maxId = 0;
    foreach ($etudiants as $etudiant) {
        if ($etudiant['id'] > $maxId) {
            $maxId = $etudiant['id'];
        }
    }
    return $maxId + 1;
}

function saisieEtudiant(array $etudiants): array {
    $nom    = readline("Nom       : ");
    $prenom = readline("Prenom    : ");

    do {
        $mail = readline("Email     : ");
        if (!validerEmail($mail)) {
            echo "  Email invalide. Reessayez.\n";
        } elseif (mailUnique($mail, $etudiants)) {
            echo "  Email deja utilise. Reessayez.\n";
        }
    } while (!validerEmail($mail) || mailUnique($mail, $etudiants));

    do {
        $telephone = readline("Telephone : ");
        if ($telephone !== '' && !validerTelephone($telephone)) {
            echo "  Numero invalide. Formats acceptes : 77 123 45 67 ou +221 77 123 45 67\n";
        }
    } while ($telephone !== '' && !validerTelephone($telephone));

    return [
        'nom'       => $nom,
        'prenom'    => $prenom,
        'mail'      => $mail,
        'telephone' => $telephone
    ];
}

function ajoutEtudiant(array $etds, array $etudiants): void {
    $newEtudiant = [
        "id"        => newIdEtudiant($etudiants),
        "nom"       => $etds['nom'],
        "prenom"    => $etds['prenom'],
        "mail"      => $etds['mail'],
        "telephone" => $etds['telephone']
    ];
    $etudiants[] = $newEtudiant;
    saveEtudiant($etudiants);
    echo "\n  Etudiant ajoute avec succes ! (ID : " . $newEtudiant['id'] . ")\n";
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

function modifierEtudiant(array &$etudiants): void {
    $id       = (int) readline("ID de l'etudiant a modifier : ");
    $etudiant = rechercherEtudiantParId($id, $etudiants);

    if (!$etudiant) {
        echo "  Etudiant introuvable.\n";
        return;
    }

    // Correction : on recupere le telephone avec ?? '' pour eviter le warning
    $telActuel = $etudiant['telephone'] ?? '';

    echo "  Laissez vide pour garder la valeur actuelle.\n";

    $nom    = readline("Nouveau nom [{$etudiant['nom']}] : ");
    $prenom = readline("Nouveau prenom [{$etudiant['prenom']}] : ");

    do {
        $telephone = readline("Nouveau telephone [{$telActuel}] : ");
        if ($telephone !== '' && !validerTelephone($telephone)) {
            echo "  Numero invalide. Formats acceptes : 77 123 45 67 ou +221 77 123 45 67\n";
        }
    } while ($telephone !== '' && !validerTelephone($telephone));

    do {
        $mail = readline("Nouvel email [{$etudiant['mail']}] : ");
        if ($mail === '') {
            $mail = $etudiant['mail'];
            break;
        }
        if (!validerEmail($mail)) {
            echo "  Email invalide.\n";
        } elseif ($mail !== $etudiant['mail'] && mailUnique($mail, $etudiants)) {
            echo "  Email deja utilise.\n";
        }
    } while (!validerEmail($mail) || ($mail !== $etudiant['mail'] && mailUnique($mail, $etudiants)));

    foreach ($etudiants as &$e) {
        if ($e['id'] === $id) {
            $e['nom']       = $nom !== '' ? $nom : $e['nom'];
            $e['prenom']    = $prenom !== '' ? $prenom : $e['prenom'];
            $e['mail']      = $mail;
            $e['telephone'] = $telephone !== '' ? $telephone : $telActuel;
            break;
        }
    }
    saveEtudiant($etudiants);
    echo "  Etudiant modifie avec succes !\n";
}

function supprimerEtudiant(array &$etudiants): void {
    $id       = (int) readline("ID de l'etudiant a supprimer : ");
    $etudiant = rechercherEtudiantParId($id, $etudiants);

    if (!$etudiant) {
        echo "  Etudiant introuvable.\n";
        return;
    }

    echo "  Etudiant : {$etudiant['nom']} {$etudiant['prenom']} ({$etudiant['mail']})\n";
    $confirm = readline("  Confirmer la suppression ? (o/n) : ");

    if (strtolower($confirm) === 'o') {
        foreach ($etudiants as $index => $e) {
            if ($e['id'] === $id) {
                unset($etudiants[$index]);
                break;
            }
        }
        $etudiants = array_values($etudiants);
        saveEtudiant($etudiants);
        echo "  Etudiant supprime avec succes !\n";
    } else {
        echo "  Suppression annulee.\n";
    }
}