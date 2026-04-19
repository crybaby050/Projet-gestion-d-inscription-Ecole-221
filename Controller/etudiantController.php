<?php
require_once __DIR__ . '/../Model/etudiantModel.php';

function menuEtudiant(): void {
    $data      = jsonToArray();
    $etudiants = $data['etudiants'];

    do {
        echo "\n--- MENU ETUDIANT ---\n";
        echo "1 - Lister les etudiants\n";
        echo "2 - Ajouter un etudiant\n";
        echo "3 - Modifier un etudiant\n";
        echo "4 - Supprimer un etudiant\n";
        echo "0 - Retour au menu principal\n";

        $choix = (int) readline("Votre choix : ");

        $data      = jsonToArray();
        $etudiants = $data['etudiants'];

        switch ($choix) {
            case 1:
                afficheTousLesEtudiants($etudiants);
                break;
            case 2:
                $infos = saisieEtudiant($etudiants);
                ajoutEtudiant($infos, $etudiants);
                break;
            case 3:
                modifierEtudiant($etudiants);
                break;
            case 4:
                supprimerEtudiant($etudiants);
                break;
            case 0:
                echo "  Retour au menu principal...\n";
                break;
            default:
                echo "  Choix invalide.\n";
        }
    } while ($choix !== 0);
}