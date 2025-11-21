<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = isset($_GET['country']) ? filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING) : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if ($lookup === 'cities' && !empty($country)) {
        
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            JOIN countries ON countries.code = cities.country_code
            WHERE countries.name LIKE :country
            ORDER BY cities.name
        ");
        $stmt->execute(['country' => "%$country%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        echo "<table border='1' cellpadding='5'>
                <thead>
                    <tr>
                        <th>City Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>".htmlspecialchars($row['city_name'])."</td>
                    <td>".htmlspecialchars($row['district'])."</td>
                    <td>".htmlspecialchars($row['population'])."</td>
                  </tr>";
        }
        echo "</tbody></table>";

    } else {
        
        if (!empty($country)) {
            $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
            $stmt->execute(['country' => "%$country%"]);
        } else {
            $stmt = $conn->query("SELECT * FROM countries");
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1' cellpadding='5'>
                <thead>
                    <tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>".htmlspecialchars($row['continent'])."</td>
                    <td>".htmlspecialchars($row['independence_year'] ?? 'N/A')."</td>
                    <td>".htmlspecialchars($row['head_of_state'] ?? 'N/A')."</td>
                  </tr>";
        }
        echo "</tbody></table>";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    die();
}
?>
