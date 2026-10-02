<?php
require_once "settings.php";

mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect($host, $user, $pwd, $sql_db);

$model = "";
$result = false;
$errorMessage = "";

if (!$conn) {
    $errorMessage = "Unable to connect to the database.";
} elseif (!isset($_GET["model"]) || trim($_GET["model"]) === "") {
    $errorMessage = "Please enter a model to search.";
} else {
    $model = trim($_GET["model"]);
    $safeModel = mysqli_real_escape_string($conn, $model);

    $sql = "SELECT car_id, make, model, price, yom
            FROM cars
            WHERE model LIKE '%$safeModel%'
            ORDER BY make, model";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $errorMessage = "Unable to search the car records.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Car model search results">
    <meta name="author" content="Chrissie Nguyen">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <title>Car Search Results</title>
</head>

<body>
    <main>
        <h1>Car Search Results</h1>

        <?php if ($errorMessage !== ""): ?>

            <p class="error">
                <?php echo htmlspecialchars($errorMessage); ?>
            </p>

        <?php elseif (mysqli_num_rows($result) === 0): ?>

            <p>
                No matching cars were found for
                “<?php echo htmlspecialchars($model); ?>”.
            </p>

        <?php else: ?>

            <p>
                Results for “<?php echo htmlspecialchars($model); ?>”:
            </p>

            <table>
                <caption>Matching cars</caption>

                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Make</th>
                        <th scope="col">Model</th>
                        <th scope="col">Price</th>
                        <th scope="col">Year</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($row["car_id"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["make"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["model"]); ?>
                            </td>

                            <td>
                                $<?php echo number_format((float) $row["price"], 2); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row["yom"]); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php endif; ?>

        <p><a href="search_form.php">Search again</a></p>
        <p><a href="cars.php">View all cars</a></p>
    </main>

    <?php
    if ($result) {
        mysqli_free_result($result);
    }

    if ($conn) {
        mysqli_close($conn);
    }
    ?>
</body>

</html>