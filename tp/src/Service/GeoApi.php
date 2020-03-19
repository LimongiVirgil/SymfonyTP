<?php

namespace App\Service;

use Symfony\Component\GuzzleHttp\Client;

class GeoApi
{
    public function getCommune($name,$zipcode): array
    {
        $client = new \GuzzleHttp\Client();
        if($name != ""){
            $uri = "https://geo.api.gouv.fr/communes?nom=".$name."&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre";
        } elseif ($zipcode != ""){
            $uri = "https://geo.api.gouv.fr/communes?codePostal=".$zipcode."&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre";
        }
        else {
            $uri = "https://geo.api.gouv.fr/communes?codePostal=".$zipcode."&nom=".$name."&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre";
        }

        try {
            $response = $client->request('GET', $uri);
        } catch (Exception $e) {
            return ["error" => "Serveur indisponible, réessayer ultérieurement"];
        }
        $json = $response->getBody();
        return json_decode($json, true);
    }
}