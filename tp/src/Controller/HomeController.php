<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GeoApi;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homeage")
     * @param GeoAPi $geoAPi
     */
    public function index(GeoAPi $geoAPi)
    {
        $error = "";
        $citys = [];
        if($_GET != []){
            $city= $_GET["name"];
            $zipcode= $_GET["zipcode"];
            $citys = $geoAPi->getCommune($city,$zipcode);

            return $this->render('home/index.html.twig', [
                'citys' => $citys,
                'city' => $_GET["name"],
                'zipcode' => $_GET["zipcode"],
                'error' => $error,
            ]);
        }
        return $this->render('home/index.html.twig', [
            'citys' => $citys,
            'city' => '',
            'zipcode' => '',
            'error' => $error,
        ]);
    }
}
