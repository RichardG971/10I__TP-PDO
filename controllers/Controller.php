<?php
abstract class Controller
{
    // Méthodes static
    static public function f_ch_retourBdd($str)
    {
        $str = stripslashes(html_entity_decode($str));
        return $str;
    }
    
    // Pour changer le format des dates.
    static public function dateFormatMnumber($D)
    {
        $D = date('d-m-Y', strtotime($D));
        return $D;
    }
    
    // Pour écrire les dates avec les mois en français.
    static public function dateFormatMletter($D)
    {
        $tabMois = [ '01' => 'janvier', '02' => 'février', '03' => 'mars', '04' => 'avril', '05' => 'mai', '06' => 'juin', '07' => 'juillet', '08' => 'août', '09' => 'septembre', '10' => 'octobre', '11' => 'novembre', '12' => 'décembre' ];
        $D = date('d-m Y', (strtotime($D)));
        foreach($tabMois as $key => $value)
        {
            if(substr($D, 3, 2) == $key) { $D = str_replace('-'.$key, ' '.$value, $D); }
        }
        return $D;
    }

    // Pour ajouter l''alt' aux images sans écrire leur extension avec 'substr($string, $start, $lenght)' :
    //   $string = la variable contenant le nom de l'image,
    //   $start = '0' car on prends le nom complet,
    //   $length = 'strrpos($img, '.')' permet de récupérer la position du dernier '.' s'il y en a plusieurs et donc de donner cette longueur à la chaîne.
    static public function f_imgAlt($img)
    {
        return substr($img, 0, strrpos($img, '.'));
    }

    // Formatage des données récupérées du formulaire après soumission.
    //    Donner en 'value' des champs les données récupérées pour que le client n'est pas à tout re-saisir en cas d'erreur.
    // Mettre la donnée soumise du champ 'nom' en majuscule avec cette fonction.
    static public function f_ch_recupFormFormatUpper($str)
    {
        $str = trim($str);
        $str = preg_replace('/[-\']/', ' ', $str);
        $tabStrReplace = [ 'a' => ['à', 'â', 'ä', 'Â', 'Ä'], 'e' => ['é', 'è', 'ê', 'ë', 'Ê', 'Ë'], 'i' => ['î', 'ï', 'Î', 'Ï'], 'o' => ['ô', 'ö', 'Ô', 'Ö'], 'u' => ['ù', 'û', 'ü', 'Û', 'Ü'], 'y' => ['ÿ'] ];
        foreach($tabStrReplace as $key => $tab)
        {
            foreach($tab as $value) { $str = str_replace($tab, $key, $str); }
        }
        $str = strtoupper($str);
        return $str;
    }

    // Mettre les données soumises des champs avec la première lettre de chaque mot en majuscule avec cette fonction.
    static public function f_ch_recupFormFormat($str)
    {
        $str = trim($str);
        $str = preg_replace('/[,.-]/', ' ', $str);
        $str = preg_replace('/ +/', ' ', $str);
        $tabStrReplaceUcf = [ 'a' => ['à'], 'e' => ['é', 'è'], 'i' => ['î', 'ï'], 'o' => ['ô', 'ö'], 'u' => ['û', 'ü'] ];
        $tabStrReplace = [ 'a' => ['â', 'ä', 'Â', 'Ä'], 'e' => ['ê', 'ë', 'Ê', 'Ë'], 'i' => ['Î', 'Ï'], 'o' => ['Ô', 'Ö'], 'u' => ['ù', 'Û', 'Ü'], 'y' => ['ÿ'] ];
        foreach($tabStrReplaceUcf as $key => $tab)
        {
            foreach($tab as $value)
            {
                if(substr($str, 0, 2) == $value) { $str = substr_replace($str, $key, 0, 2); }
            }
        }
        foreach($tabStrReplace as $key => $tab)
        {
            foreach($tab as $value) { $str = str_replace($tab, $key, $str); }
        }
        $str = htmlentities($str); // Convertir en entités HTML car 'strtolower()' ne reconnaît pas les caractères accentués,
        $str = strtolower($str); // tout convertir en minuscule,
        $str = html_entity_decode($str); // décodé l'encodement avec 'htmlentities()',
        $str = ucwords($str); // mettre la première lettre de chaque mot en majuscule.
        $tabStrReplace = [ 'd\'' => ['D\''], 'l\'' => ['L\''], '\'A' => ['\'a', '\'à', '\'â', '\'ä', '\'Â', '\'Ä'], '\'E' => ['\'e', '\'é', '\'è', '\'ê', '\'ë', '\'Ê', '\'Ë'], '\'I' => ['\'i', '\'î', '\'ï', '\'Î', '\'Ï'], '\'O' => ['\'o', '\'ô', '\'ö', '\'Ô', '\'Ö'], '\'U' => ['\'u', '\'ù', '\'û', '\'ü', '\'Û', '\'Ü'], '\'Y' => ['\'y', '\'ÿ'] ];
        $tabStrReplace += [ ' A' => [' à'], ' E' => [' é', ' è'], ' I' => [' î', ' ï'], ' O' => [' ô', ' ö'], ' U' => [' û', ' ü'], 'd ' => ['D '], 'l ' => ['L '] ];
        foreach($tabStrReplace as $key => $tab)
        {
            foreach($tab as $value) { $str = str_replace($tab, $key, $str); }
        }
        return $str;
    }
    
    // Formatage des données récupérées de la base de données et des '$var_rec' du formulaire pour les comparer.
    static public function f_ch_retourBddUpper($str)
    {
        $str = trim($str);
        $str = preg_replace('/[-\']/', ' ', $str);
        $tabStrReplace = [ 'a' => ['à', 'â', 'ä', 'Â', 'Ä'], 'e' => ['é', 'è', 'ê', 'ë', 'Ê', 'Ë'], 'i' => ['î', 'ï', 'Î', 'Ï'], 'o' => ['ô', 'ö', 'Ô', 'Ö'], 'u' => ['ù', 'û', 'ü', 'Û', 'Ü'], 'y' => ['ÿ'] ];
        foreach($tabStrReplace as $key => $tab)
        {
            foreach($tab as $value) { $str = str_replace($tab, $key, $str); }
        }
        $str = strtoupper($str);
        return $str;
    }

    static public function f_ch_retourBddUcwords($str)
    {
        $str = stripslashes(html_entity_decode($str));
        $str = Controller::f_ch_retourBddUpper($str);
        $str = strtolower($str);
        $str = ucwords($str);
        return $str;
    }
}