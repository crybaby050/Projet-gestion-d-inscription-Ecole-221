<?php 
    require_once __DIR__ . '/communeModel.php';
    $etudiants = $data['etudiants'];
    //var_dump($etudiant);

    function mailUnique($mail){
    foreach($etudiants as $etudiant){
        if($etudiant['mail'] == $mail){
            return true;
        }
    }
    return false;
}


?>