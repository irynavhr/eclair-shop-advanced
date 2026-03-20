<!-- FOR SET UP SERVICES ONLY!!! -->
<?php
require_once 'includes/db.php';
require_once 'classes/Service.php';

// READ JSON FILE
$json = file_get_contents('services.json');
$servicesArray = json_decode($json, true);

// IF ERROR - END
if (!$servicesArray) {
    die("Errore reading JSON.");
}

// NEW SERVICE OBJECT
$service = new Service($pdo);

// DEFINE VALUES
foreach ($servicesArray as $item) {
    $title = $item['title'];
    $description = $item['description'];
    $image = $item['image'];
    $keywords = $item['keywords'] ?? '';
    $category = $item['category'] ?? '';
    $price = $item['price'];

    // IS THERE THE ECLAIR OLREADY
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE title = ?");
    $stmt->execute([$title]);
    $count = $stmt->fetchColumn();
    // IF NO - ADD ECLAIR
    if ($count == 0) {
        $service->create($title, $description, $image, $keywords, $category, $price);
        echo "Added: $title<br>";
    } else {
        echo "Missed, already exist: $title<br>";
    }
}

?>
