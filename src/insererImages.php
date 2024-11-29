<?php
declare(strict_types=1);
use Iutnc\Nrv\repository\NrvRepository;
require __DIR__ . '/../vendor/autoload.php';

NrvRepository::setConfig(__DIR__ . '/../config/nrv.db.ini');
$pdo = NrvRepository::getInstance()->getPDO();

//images à inserer, dans l'ordre de l'id de la table image
$imagesAModifier = ['../imagesTest/rockLegends.jpg','../imagesTest/punk.png','../imagesTest/indieNight.jpg', '../imagesTest/redLed.jpg'];

//on modifie chaque image à NULL avec l'image correspondante
for($id = 1; $id<=count($imagesAModifier); $id++){
    $imageData = base64_encode(file_get_contents($imagesAModifier[$id-1]));//-1 car les indices du tableau commencent à 0

    $stmt = $pdo->prepare("UPDATE image SET data = :image WHERE id = :id AND data IS NULL");
    $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

//on veut ajouter des tuples complets dans la table image corespondants aux images des lieux via la table lieu2image

$imagesLieu = ['../imagesTest/theatre.jpg','../imagesTest/sallePoirel.jpg','../imagesTest/centreProuve.jpg'];
$descriptions = ['Photo du Theatre de Nancy', 'Photo de la Salle Poirel', 'Photo du Centre Culturel Jean Prouvé'];

for($i = 0; $i<count($imagesLieu); $i++){
    $imageData = base64_encode(file_get_contents($imagesLieu[$i])) ;

    $stmt = $pdo->prepare("INSERT INTO image (filetype, description, data) VALUES ('image/jpeg', :description, :image)");
    $stmt->bindParam(':description', $descriptions[$i]);
    $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);

    $stmt->execute();
}

//on change les id des images de lieu qui ne correspondaient pas
$newId = [5, 6, 7];
$ancienId = [4, 3, 2];
for($i = 0; $i<count($newId); $i++){
    $stmt = $pdo->prepare("UPDATE lieu2image SET id_image = :idImage WHERE id_lieu = $i+1 AND id_image = {$ancienId[$i]}");
    $stmt->bindParam(':idImage', $newId[$i]);
    $stmt->execute();
}





