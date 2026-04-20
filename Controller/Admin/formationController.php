<?php
require_once __DIR__ . '/../../Model/formationModel.php';

function menuFormation(): void {
    $data       = jsonToArray();
    $formations = $data['formations'];

    do {
        echo "\n--- MENU FORMATION ---\n";
        echo "1 - Lister les formations\n";
        echo "2 - Ajouter une formation\n";
        echo "3 - Modifier une formation\n";
        echo "4 - Supprimer une formation\n";
        echo "0 - Retour au menu principal\n";

        $choix = (int) readline("Votre choix : ");

        $data       = jsonToArray();
        $formations = $data['formations'];

        switch ($choix) {
            case 1:
                afficheToutesLesFormations($formations);
                break;
            case 2:
                $infos = saisieFormation($formations);
                ajoutFormation($infos, $formations);
                break;
            case 3:
                modifierFormation($formations);
                break;
            case 4:
                supprimerFormation($formations);
                break;
            case 0:
                echo "  Retour au menu principal...\n";
                break;
            default:
                echo "  Choix invalide.\n";
        }
    } while ($choix !== 0);
}