<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Charger les données depuis le fichier CSV
        $data = $this->loadDataFromCsv('/chemin/vers/le/fichier.csv');
        // Créer des entités et les persister
        foreach ($data as $row) {
            $entity = new YourEntity(); // Remplacez YourEntity par le nom de votre entité
            // Affectez les valeurs des colonnes du CSV à vos propriétés d'entité
            // $entity->setPropriete($row['nom_de_la_colonne']);
            $manager->persist($entity);
        }

        // Exécuter les requêtes SQL
        $manager->flush();
    }

    private function loadDataFromCsv($filePath)
    {
        // Créer un tableau pour stocker les données du CSV
        $data = [];

        // Ouvrir le fichier CSV en mode lecture ('r')
        if (($handle = fopen($filePath, 'r')) !== false) {

            // Tant qu'il y a des lignes dans le fichier CSV
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Ajouter la ligne (un tableau) au tableau de données
                $data[] = $row;
            }

            // Fermer le fichier CSV
            fclose($handle);
        }

        // Retourner le tableau de données
        return $data;
    }
}