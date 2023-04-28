<?php 
// // Obtenir l'URL demandée
// $url = $_SERVER['REQUEST_URI'];

class Router {
    public function handle($url, array $routes) {
        // comparer les clés de routes à url
        if(! array_key_exists($url, $routes)) {
            // Route pas trouvée
            http_response_code(404);
            exit('Mais elle est ou la route ?');
        }

        // J'ai trouvé une route

        $controllerClass = $routes[$url][0];
        $controllerMethod = $routes[$url][1];
        if(!method_exists($controllerClass, $controllerMethod)){
            // Route pas trouvée
            http_response_code(404);
            exit('Method not found ');
        }

        $controller = new $controllerClass();
        return $controller->$controllerMethod();

    }
    
    // function Routes($id, $title, $resume, $author){
    //     $books = new Books($id, $title, $resume, $author);

    //     if(isset($_GET['books'])){
    //         $books->showBooks();
    //     }
    // }
}

