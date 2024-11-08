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
    $imageData = file_get_contents($imagesAModifier[$id-1]);//-1 car les indices du tableau commencent à 0

    $stmt = $pdo->prepare("UPDATE image SET data = :image WHERE id = :id AND data IS NULL");
    $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

//on veut ajouter des tuples complets dans la table image corespondants aux images des lieux via la table lieu2image

$imagesLieu = ['../imagesTest/theatre.jpg','../imagesTest/sallePoirel.jpg','../imagesTest/centreProuve.jpg'];
$descriptions = ['Theatre de Nancy', 'Salle Poirel', 'Centre Culturel Jean Prouvé'];

for($i = 0; $i<count($imagesLieu); $i++){
    $imageData = file_get_contents($imagesLieu[$i]);

    $stmt = $pdo->prepare("INSERT INTO image (filetype, description, data) VALUES ('jpg', :description, :image)");
    $stmt->bindParam(':description', $descriptions[$i]);
    $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);

    $stmt->execute();
}




