<?php
require_once __DIR__ . '/etudiantController.php';
require_once __DIR__ . '/formationController.php';

function menuAdmin(): void {
    do {
        echo "\n--- MENU ADMINISTRATEUR ---\n";
        echo "1 - Gestion des etudiants\n";
        echo "2 - Gestion des formations\n";
        echo "0 - Retour au menu principal\n";

        $choix = (int) readline("Votre choix : ");

        switch ($choix) {
            case 1:
                menuEtudiant();
                break;
            case 2:
                menuFormation();
                break;
            case 0:
                echo "  Retour au menu principal...\n";
                break;
            default:
                echo "  Choix invalide.\n";
        }
    } while ($choix !== 0);
}