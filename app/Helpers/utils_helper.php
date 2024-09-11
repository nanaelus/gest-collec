<?php

if (!function_exists('generate_slug')) {
    function generateSlug($string)
    {
        // Normaliser la chaîne pour enlever les accents
        $string = \Normalizer::normalize($string, \Normalizer::FORM_D);
        $string = preg_replace('/[\p{Mn}]/u', '', $string);

        // Convertir les caractères spéciaux en minuscules et les espaces en tirets
        $string = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

        return $string;
    }
}

if (!function_exists('upload_file')) {

    /**
     * Gérer l'upload d'un fichier dans un dossier organisé par année/mois, avec un nom de fichier slugifié.
     * Mettre à jour ou insérer les informations du média dans la base de données.
     *
     * @param \CodeIgniter\Files\File $file - Le fichier à uploader
     * @param string $subfolder - Un sous-dossier optionnel pour organiser les fichiers
     * @param string|null $customName - Le nom personnalisé pour le fichier (par exemple, nom d'utilisateur ou titre d'item)
     * @param array|null $mediaData - Données du média à insérer dans la base de données
     * @param bool $isMultiple - Indique si plusieurs images sont autorisées pour cet entity_id et entity_type
     * @return string|false - Le chemin du fichier uploadé ou false en cas d'échec
     */
    function upload_file($file, $subfolder = '', $customName = null, $mediaData = null, $isMultiple = false)
    {
        if ($file->isValid() && !$file->hasMoved()) {

            // Obtenir l'année et le mois actuels
            $year = date('Y');
            $month = date('m');

            // Construire le chemin de l'upload dans /public/uploads/année/mois/
            $uploadPath = "uploads/$year/$month";

            // Ajouter un sous-dossier si spécifié
            if (!empty($subfolder)) {
                $uploadPath .= "/$subfolder";
            }

            // Créer le dossier s'il n'existe pas
            if (!is_dir(FCPATH . $uploadPath)) {
                mkdir(FCPATH . $uploadPath, 0755, true);
            }

            // Générer un nom de fichier unique basé sur le nom personnalisé (ou un nom aléatoire)
            if ($customName) {
                // Générer un slug à partir du nom personnalisé
                $slug = generateSlug($customName);
                // Ajouter l'extension originale du fichier
                $extension = $file->getExtension();
                // Créer un nom unique en ajoutant un timestamp pour éviter les doublons
                $newName = $slug . '-' . time() . '.' . $extension;
            } else {
                // Si aucun nom personnalisé, utiliser un nom aléatoire
                $newName = $file->getRandomName();
            }

            // Déplacer le fichier vers le dossier uploads/année/mois
            $file->move(FCPATH . $uploadPath, $newName);

            // Retourner le chemin relatif du fichier
            $filePath = "$uploadPath/$newName";

            if ($mediaData) {
                $mediaModel = model('MediaModel');

                if ($isMultiple) {
                    // Pour les entités où plusieurs images sont autorisées, on insère directement
                    $mediaModel->insert(array_merge($mediaData, ['file_path' => $filePath]));
                } else {
                    // Pour les entités avec une image unique, on gère la mise à jour ou la suppression des anciennes entrées
                    $existingMedia = $mediaModel->where([
                        'entity_id' => $mediaData['entity_id'],
                        'entity_type' => $mediaData['entity_type']
                    ])->first();

                    if ($existingMedia) {
                        // Mettre à jour les champs file_path et created_at de l'enregistrement existant
                        $mediaModel->update($existingMedia['id'], [
                            'file_path' => $filePath,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        // Supprimer les anciennes entrées pour le même entity_id et entity_type
                        $mediaModel->where([
                            'entity_id' => $mediaData['entity_id'],
                            'entity_type' => $mediaData['entity_type']
                        ])->delete();

                        // Insérer le nouvel enregistrement
                        $mediaModel->insert(array_merge($mediaData, ['file_path' => $filePath]));
                    }
                }
            }

            return $filePath;
        }

        // En cas d'échec, retourner false
        return false;
    }
}