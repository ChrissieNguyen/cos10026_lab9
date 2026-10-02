<?php

// http://localhost/cos10026_lab9/cars.php
require_once "settings.php";
$db_conn = @mysqli_connect($host, $user, $pwd, $sql_db);

$result = false;
$errorMessage = "";

if (!$db_conn) {
    $errorMessage = "Unable to connect to the database";
} else {
    $query = "SELECT car_id, make, model, price, yom FROM cars ORDER BY make, model";
    $result = mysqli_query($db_conn, $query);

    if (!$result) {
        $errorMessage = "Unable to retrieve the records";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Used cars available from the dealership">
    <meta name="author" content="Chrissie Nguyen">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <title>Used Cars</title>
</head>

<body>
    <h1>Used Cars</h1>
    <?php if ($errorMessage !== ""): ?>

        <p class="error">
            <?php echo htmlspecialchars($errorMessage); ?>
        </p>

    <?php elseif (mysqli_num_rows($result) === 0): ?>

        <p>There are no cars to display.</p>

    <?php else: ?>

        <table style="border: 1px solid black;">

            <caption>Cars currently available for purchase</caption>
            <styles>th,
                td {
                border: 1px solid black;
                }</styles>
            <thead>
                <tr>
                    <th scope="col">Car ID</th>
                    <th scope="col">Make</th>
                    <th scope="col">Model</th>
                    <th scope="col">Price</th>
                    <th scope="col">Year of manufacture</th>
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
</body>

</html>