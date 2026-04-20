<?php
require_once __DIR__ . '/../../Model/formationModel.php';

function menuEtudiantPublic(): void {
    do {
        echo "\n--- ESPACE ETUDIANT ---\n";
        echo "1 - Consulter les formations disponibles\n";
        echo "0 - Retour au menu principal\n";

        $choix = (int) readline("Votre choix : ");

        $data       = jsonToArray();
        $formations = $data['formations'];

        switch ($choix) {
            case 1:
                afficheToutesLesFormations($formations);
                break;
            case 0:
                echo "  Retour au menu principal...\n";
                break;
            default:
                echo "  Choix invalide.\n";
        }
    } while ($choix !== 0);
}