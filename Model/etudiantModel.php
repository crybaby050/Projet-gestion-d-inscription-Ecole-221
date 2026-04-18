<?php 
    require_once __DIR__ . '/communeModel.php';
    $etudiants = $data['etudiants'];
    //var_dump($etudiant);

    //fonction pour sauvegarder les etudiants dans le fichier dans le fichier json
function saveEtudiant($etudiant) {
    $path = __DIR__ . '/../Data/data.json';
    $data = ['etudiants' => $etudiant];
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json);
}

function mailUnique($mail){
    foreach($etudiants as $etudiant){
        if($etudiant['mail'] == $mail){
            return true;
        }
    }
    return false;
}

function validerEmail($email) {
    $email = trim($email);
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $email) === 1;
}

function newId(): int {
    $maxId = 0;
        foreach ($etudiants as $etudiant) {
            if ($etudiant['id'] > $maxId) {
                $maxId = $etudiant['id'];
            }
        }
    return $maxId + 1;
}

function saisieEtudiant(){

}

function ajoutEtudiant($etds){
    $newEtudiant = [
        "id" => newId(),
        "nom" => $etds['nom'],
        "prenom" => $etds['pre'],
        "mail" => $etds['mail']
    ];
    $etudiant[] = $newEtudiant;
    saveEtudiant($etudiant);
    return $newEtudiant;
}



?>