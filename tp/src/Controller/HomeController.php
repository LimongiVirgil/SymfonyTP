<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GeoApi;
use App\Service\EtablissementPublicApi;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homeage")
     * @param GeoAPi $geoAPi
     * @param EtablissementPublicApi $etablissement
     */
    public function index(GeoAPi $geoAPi, EtablissementPublicApi $etablissement)
    {
        $error = "";
        $errorEtablissement = "";
        $citys = [];
        if($_GET != []){
            $city= $_GET["name"];
            $zipcode= $_GET["zipcode"];

            $citys = $geoAPi->getCommune($city,$zipcode);
            //$etablissements = $etablissement->getEtablissement($citys[0]["code"]);

            $error = "";
            if ($citys == []){
                $error = "Aucune ville trouvé avec ces renseignements";
            } else {
                $etablissements = $etablissement->getEtablissement($citys[0]["code"]);
            }
            if (!isset($etablissements) ) {
                $errorEtablissement = "Aucune information sur cette ville";

                return $this->render('home/index.html.twig', [
                    'citys' => $citys,
                    'city' => $_GET["name"],
                    'zipcode' => $_GET["zipcode"],
                    'error' => $error,
                    'errorEtablissement' => $errorEtablissement
                ]);
            }

            return $this->render('home/index.html.twig', [
                'citys' => $citys,
                'etablissement' =>  $etablissements["features"],
                'city' => $_GET["name"],
                'zipcode' => $_GET["zipcode"],
                'error' => $error,
                'errorEtablissement' => $errorEtablissement
            ]);
        }
        return $this->render('home/index.html.twig', [
            'citys' => $citys,
            'city' => '',
            'zipcode' => '',
            'error' => $error,
            'errorEtablissement' => $errorEtablissement
        ]);
    }
}
