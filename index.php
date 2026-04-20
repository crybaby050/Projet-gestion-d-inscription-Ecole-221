<?php
require_once __DIR__ . '/Controller/Admin/adminController.php';
require_once __DIR__ . '/Controller/Etudiant/etudiantController.php';

echo "================================\n";
echo "  ECOLE 221 - Gestion des inscriptions\n";
echo "================================\n";

do {
    echo "\n=== MENU PRINCIPAL ===\n";
    echo "Qui etes-vous ?\n";
    echo "1 - Administrateur\n";
    echo "2 - Etudiant\n";
    echo "0 - Quitter\n";

    $choix = (int) readline("Votre choix : ");

    switch ($choix) {
        case 1:
            menuAdmin();
            break;
        case 2:
            menuEtudiantPublic();
            break;
        case 0:
            echo "\nAu revoir !\n";
            break;
        default:
            echo "  Choix invalide.\n";
    }
} while ($choix !== 0);