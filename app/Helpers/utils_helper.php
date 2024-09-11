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