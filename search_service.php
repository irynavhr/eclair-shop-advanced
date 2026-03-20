<?php
require_once 'includes/db.php'; // CONNECT TO DATABASE
require_once 'classes/Service.php'; // INCLUDE SERVICE CLASS

$service = new Service($pdo); // CREATE SERVICE OBJECT

$q = $_GET["q"] ?? ''; // GET SEARCH QUERY FROM URL PARAMETER

$output = ""; // INITIALIZE OUTPUT STRING

if ($q !== "") {
    $results = $service->search($q); // SEARCH SERVICES BY QUERY

    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        // IF OUTPUT IS EMPTY, ADD FIRST TITLE
        if ($output === "") {
            $output = htmlspecialchars($row["title"]);
        } else {
            // OTHERWISE, ADD NEXT TITLE WITH COMMA
            $output .= ", " . htmlspecialchars($row["title"]);
        }
    }
}

// IF OUTPUT IS STILL EMPTY, SHOW "NO SUGGESTION", ELSE SHOW OUTPUT
echo $output === "" ? "no suggestion" : $output;

