<?php

namespace App\Service;

use Symfony\Component\GuzzleHttp\Client;

class EtablissementPublicApi
{
    public function getEtablissement($zipcode): array
    {
        $client = new \GuzzleHttp\Client();
        if ($zipcode != ""){
            $uri = "https://etablissements-publics.api.gouv.fr/v3/communes/$zipcode/mairie";
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