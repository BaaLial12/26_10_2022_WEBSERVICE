<?php
namespace App\Service;

use App\Modelo\Pelicula;


$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
//Para meternos en una libreria de vendor hay que poner \ antes de especificar la url
$dotenv->load();

// require __DIR__."/../../vendor/autoload.php";

//Pillamos la api
// define("URL","https://api.themoviedb.org/3/movie/popular?api_key=885efee363c9386489d59769157c052e&page=1");
//Para poder coger las img TENEMOS que definirlas en una constante
// define("IMG", "https://image.tmdb.org/t/p/w500");

define("URL", $_ENV['URL_BASE'].$_ENV['API_KEY']);
define("IMG", $_ENV['URL_IMG']);



class ApiService{
    public function getPeliculas():array{
        $peliculas=[];
        $datos = file_get_contents(URL);
        $datosJson=json_decode($datos);
        $datosPelis=$datosJson->results;
        

        foreach($datosPelis as $objetoPelicula){
            $peliculas[]=(new Pelicula)
            ->setTitulo($objetoPelicula->title)
            ->setResumen($objetoPelicula->overview)
            ->setCaratula(IMG.$objetoPelicula->backdrop_path)
            ->setPoster(IMG.$objetoPelicula->poster_path)
            ->setFecha($objetoPelicula->release_date);
        }

        // echo "<pre>";
        // var_dump($peliculas);
        // echo "</pre>";
        return $peliculas;

    }

}
// (new ApiService)->getPeliculas();