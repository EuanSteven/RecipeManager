<?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "password1";
    $dbname = "prod";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get recipe ID from URL parameter
    $recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $recipe_name = isset($_GET['recipe']) ? htmlspecialchars($_GET['recipe']) : 'your recipe';
    
    // Fetch recipe name
    $sql = "SELECT recipe_name FROM recipes WHERE recipe_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recipe_name = htmlspecialchars($row['recipe_name']);
    } else {
        $recipe_name = 'your recipe';
    }

    // Close database connection
    $stmt->close();
    $conn->close();
?>

<!doctype html>
<html lang="en">
<!-- Design by Euan Steven -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Thank You">
    <meta name="author" content="Euan Steven">

    <title>Thank You</title>

    <meta property="og:title" content="Thank You">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/assets/img/covers/thankyou.png">
    <meta property="og:description" content="Thank You">
    <meta property="og:locale" content="en_GB">

    <link rel="icon" type="image/x-icon" href="/assets/img/icons/favicon.ico">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
    <div class="intro">
        <h1>Recipe Manager</h1>
        <h2>// Thank You</h2>
    </div>

    <div class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#A19a9a">
            <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/>
        </svg>
        <span><a class="back" href="/index.php">Back</a></span>
    </div>

    <div class="success-container">
        <div class="success-message">
            <h2>Successful!</h2>
            <p>Thank you for submitting <?php echo $recipe_name; ?></p>
        </div>

        <table class="recipe-table">
            <thead>
                <tr>
                    <th>Recipe Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $recipe_name; ?></td>
                    <td>Successfully Added</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>