<?php
require 'db.php';


if (!is_dir('cache')) {
    mkdir('cache', 0755, true);
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['erro' => 'ID do filme não fornecido']);
    exit;
}


$filmes_extras = [
    7 => [
        "title" => "The Force Awakens",
        "episode_id" => 7,
        "opening_crawl" => "Decades after the fall of Darth Vader and the Empire, a new threat emerges: the First Order, a shadowy organization that seeks to undermine the power of the Republic and that includes Kylo Ren (Adam Driver), General Hux (Domhnall Gleeson) and the Leader Supreme Snoke (Andy Serkis) as main exponents. They manage to capture Poe Dameron (Oscar Isaac), one of the Resistance's main pilots, who, before being arrested, sends the map of where the mythological Luke Skywalker (Mark Hamill) lives via the small robot BB-8. While fleeing through the desert, BB-8 encounters young Rey (Daisy Ridley), who lives alone collecting wreckage from ancient ships. At the same time, Poe receives help from Finn (John Boyega), a stormtrooper who decides to suddenly abandon his post. Together, they escape the First Order's rule.",
        "director" => "J.J. Abrams",
        "producer" => "Kathleen Kennedy, J.J. Abrams, Bryan Burk",
        "release_date" => "2015-12-18",
        "characters" => [
        "Anakin Skywalker", "Andrithal Robb-Voti", "Athgar Heece", "Bazine Netal", 
        "BB-8", "B-U4D", "Bobbajo", "Brasmon Kee", "C-3PO", "Caluan Ematt", 
        "Cherff Maota", "Chewbacca", "Connix", "Cratinus", "Crokind Sand", 
        "Dasha Promenti", "Ello Asty", "Finn", "GA-97", "Gial Ackbar", 
        "Goss Toowers", "Gwellis Bagnoro", "Grumgarr", "Han Solo", "Hux", 
        "Jashco Phurus", "Jessika Pava", "Kylo Ren", "Korr Sella", 
        "Lanever Villecham", "Leia Organa", "Lor San Tekka", "Luke Skywalker", 
        "Maz Kanata", "ME-8D9", "Munduri", "Nahani Gillen", "Nien Nunb", 
        "Phasma", "Poe Dameron", "Prashee", "Praster Ommlen", 
        "Pru Sweevant", "Quiggold", "PZ-4CO", "R2-D2", "Razoo Qin-Fee", 
        "Rey", "Roodown", "Sarco Plank", "Sidon Ithano", "Snoke", 
        "Sonsigo", "Tasu Leech", "Teedo", "Temmin Wexley", 
        "Thandlé Berenko", "Thanlis Depallo", "Unkar Plutt", "Wollivan", "Zuvio"
    ]],
    8 => [
        "title" => "The Last Jedi",
        "episode_id" => 8,
        "opening_crawl" => "Luke Skywalker's quiet and lonely life takes a turn for the worse when he meets Rey, a young woman who shows strong signs of the Force. Her desire to learn the ways of the Jedi forces Luke to make a decision that will change his life forever. Meanwhile, Kylo Ren and General Hux lead the First Order in an all-out assault against Leia and the Resistance for supremacy of the galaxy.",
        "director" => "Rian Johnson",
        "producer" => "Kathleen Kennedy, Ram Bergman",
        "release_date" => "2017-12-15",
        "characters" => [],
    ],
    9 => [
        "title" => "The Rise of Skywalker",
        "episode_id" => 9,
        "opening_crawl" => "With the return of Emperor Palpatine, the Resistance takes the lead in battle. Training to be a complete Jedi, Rey finds herself conflicted with her past and future, and fears for the answers she can get from Kylo Ren.",
        "director" => "J.J. Abrams",
        "producer" => "Kathleen Kennedy, J.J. Abrams, Michelle Rejwan",
        "release_date" => "2019-12-20",
        "characters" => [],
    ],
];


if (isset($filmes_extras[$id])) {
    echo json_encode($filmes_extras[$id]);
    exit;
}


$ch = curl_init("https://swapi.dev/api/films/$id/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    echo json_encode(['erro' => 'Erro ao buscar dados da API']);
    exit;
}


$sql = "INSERT INTO logs (data_hora, solicitacao) VALUES (NOW(), 'Detalhes do filme ID $id')";
$pdo->query($sql);


$json_data = json_encode($response);
file_put_contents("cache/filme_$id.json", $json_data);


echo $response;
?>
