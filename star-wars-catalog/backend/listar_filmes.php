<?php
require 'db.php';


$cacheFile = 'cache/filmes.json';


if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 3600) {
    
    $filmes = json_decode(file_get_contents($cacheFile), true);
} else {
    
    $ch = curl_init('https://swapi.dev/api/films/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    
    if ($response === false) {
        error_log('Erro na requisição: ' . curl_error($ch));
        $filmes = [];
    } else {
        $data = json_decode($response, true);
        $filmes = $data['results'] ?? []; 
        $filmes[] = [
            "title" => "The Force Awakens",
            "episode_id" => 7,
            "opening_crawl" => "Decades after the fall of Darth Vader and the Empire, a new threat emerges: the First Order, a shadowy organization that seeks to undermine the power of the Republic and that includes Kylo Ren (Adam Driver), General Hux (Domhnall Gleeson) and the Leader Supreme Snoke (Andy Serkis) as main exponents. They manage to capture Poe Dameron (Oscar Isaac), one of the Resistance's main pilots, who, before being arrested, sends the map of where the mythological Luke Skywalker (Mark Hamill) lives via the small robot BB-8. While fleeing through the desert, BB-8 encounters young Rey (Daisy Ridley), who lives alone collecting wreckage from ancient ships. At the same time, Poe receives help from Finn (John Boyega), a stormtrooper who decides to suddenly abandon his post. Together, they escape the First Order's rule.",
            "director" => "J.J. Abrams",
            "producer" => "Kathleen Kennedy, J.J. Abrams, Bryan Burk",
            "release_date" => "2015-12-18",
            "characters" => [],
            "url" => "/filme?id=7"
        ];

        $filmes[] = [
            "title" => "The Last Jedi",
            "episode_id" => 8,
            "opening_crawl" => "Luke Skywalker's quiet and lonely life takes a turn for the worse when he meets Rey, a young woman who shows strong signs of the Force. Her desire to learn the ways of the Jedi forces Luke to make a decision that will change his life forever. Meanwhile, Kylo Ren and General Hux lead the First Order in an all-out assault against Leia and the Resistance for supremacy of the galaxy.",
            "director" => "Rian Johnson",
            "producer" => "Kathleen Kennedy, Ram Bergman",
            "release_date" => "2017-12-15",
            "characters" => [],
            "url" => "/filme?id=8" 
        ];

        $filmes[] = [
            "title" => "The Rise of Skywalker",
            "episode_id" => 9,
            "opening_crawl" => "With the return of Emperor Palpatine, the Resistance takes the lead in battle. Training to be a complete Jedi, Rey finds herself conflicted with her past and future, and fears for the answers she can get from Kylo Ren.",
            "director" => "J.J. Abrams",
            "producer" => "Kathleen Kennedy, J.J. Abrams, Michelle Rejwan",
            "release_date" => "2019-12-20",
            "characters" => [],
            "url" => "/filme?id=9"
        ];

    
        usort($filmes, function ($a, $b) {
            return strtotime($a['release_date']) - strtotime($b['release_date']);
        });

      
        file_put_contents($cacheFile, json_encode($filmes));

      
        $sql = "INSERT INTO logs (data_hora, solicitacao) VALUES (NOW(), 'Listagem de filmes')";
        $pdo->query($sql);
    }

    curl_close($ch);
}


header('Content-Type: application/json'); 
echo json_encode($filmes);
?>
