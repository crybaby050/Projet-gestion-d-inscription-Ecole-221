<?php
require_once __DIR__ . '/Controller/etudiantController.php';
require_once __DIR__ . '/Controller/formationController.php';

echo "================================\n";
echo "  ECOLE 221 - Gestion des inscriptions\n";
echo "================================\n";

do {
    echo "\n=== MENU PRINCIPAL ===\n";
    echo "1 - Gestion des etudiants\n";
    echo "2 - Gestion des formations\n";
    echo "0 - Quitter\n";

    $choix = (int) readline("Votre choix : ");

    switch ($choix) {
        case 1:
            menuEtudiant();
            break;
        case 2:
            menuFormation();
            break;
        case 0:
            echo "\nAu revoir !\n";
            break;
        default:
            echo "  Choix invalide.\n";
    }
} while ($choix !== 0);