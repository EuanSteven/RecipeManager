<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "password1";
$dbname = "prod";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $recipe_name = sanitize_input($_POST["recipe_name"]);
    $serving_size = sanitize_input($_POST["serving_size"]);
    $cooking_time = intval($_POST["cooking_time"]);
    $directions = sanitize_input($_POST["directions"]);
    $vegan = isset($_POST["vegan"]) ? 1 : 0;
    $vegetarian = isset($_POST["vegetarian"]) ? 1 : 0;
    $gluten_free = isset($_POST["gluten_free"]) ? 1 : 0;

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into recipes table
        $sql_recipe = "INSERT INTO recipes (recipe_name, serving_size, cooking_time, directions) 
                       VALUES (?, ?, ?, ?)";
        $stmt_recipe = $conn->prepare($sql_recipe);
        if (!$stmt_recipe) {
            throw new Exception("Prepare failed for recipes: " . $conn->error);
        }
        $stmt_recipe->bind_param("ssis", $recipe_name, $serving_size, $cooking_time, $directions);
        if (!$stmt_recipe->execute()) {
            throw new Exception("Execute failed for recipes: " . $stmt_recipe->error);
        }
        $recipe_id = $stmt_recipe->insert_id;
        $stmt_recipe->close();

        // Insert ingredients and measurements
        if (isset($_POST["ingredient_name"]) && is_array($_POST["ingredient_name"])) {
            $sql_ingredient = "INSERT INTO ingredients (ingredient_name) VALUES (?)";
            $sql_measurement = "INSERT INTO measurements (recipe_id, ingredient_id, quantity, unit) VALUES (?, ?, ?, ?)";
            
            $stmt_ingredient = $conn->prepare($sql_ingredient);
            $stmt_measurement = $conn->prepare($sql_measurement);

            if (!$stmt_ingredient || !$stmt_measurement) {
                throw new Exception("Prepare failed for ingredients/measurements: " . $conn->error);
            }

            foreach ($_POST["ingredient_name"] as $key => $ingredient_name) {
                $ingredient_name = sanitize_input($ingredient_name);
                $quantity = floatval($_POST["quantity"][$key]);
                $unit = sanitize_input($_POST["unit"][$key]);

                $stmt_ingredient->bind_param("s", $ingredient_name);
                if (!$stmt_ingredient->execute()) {
                    throw new Exception("Execute failed for ingredient: " . $stmt_ingredient->error);
                }
                $ingredient_id = $stmt_ingredient->insert_id;

                $stmt_measurement->bind_param("iids", $recipe_id, $ingredient_id, $quantity, $unit);
                if (!$stmt_measurement->execute()) {
                    throw new Exception("Execute failed for measurement: " . $stmt_measurement->error);
                }
            }

            $stmt_ingredient->close();
            $stmt_measurement->close();
        }

        // Insert media links
        if (isset($_POST["media_link"]) && is_array($_POST["media_link"])) {
            $sql_media = "INSERT INTO media (recipe_id, media_link) VALUES (?, ?)";
            $stmt_media = $conn->prepare($sql_media);
            if (!$stmt_media) {
                throw new Exception("Prepare failed for media: " . $conn->error);
            }

            foreach ($_POST["media_link"] as $media_link) {
                $media_link = sanitize_input($media_link);
                $stmt_media->bind_param("is", $recipe_id, $media_link);
                if (!$stmt_media->execute()) {
                    throw new Exception("Execute failed for media: " . $stmt_media->error);
                }
            }

            $stmt_media->close();
        }

        // Insert nutrition information
        $sql_nutrition = "INSERT INTO nutrition (recipe_id, kcal, protein, carbs, fat, sugar) 
                          VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_nutrition = $conn->prepare($sql_nutrition);
        if (!$stmt_nutrition) {
            throw new Exception("Prepare failed for nutrition: " . $conn->error);
        }
        $kcal = intval($_POST["kcal"]);
        $protein = intval($_POST["protein"]);
        $carbs = intval($_POST["carbs"]);
        $fat = intval($_POST["fat"]);
        $sugar = intval($_POST["sugar"]);
        $stmt_nutrition->bind_param("iiiiii", $recipe_id, $kcal, $protein, $carbs, $fat, $sugar);
        if (!$stmt_nutrition->execute()) {
            throw new Exception("Execute failed for nutrition: " . $stmt_nutrition->error);
        }
        $stmt_nutrition->close();

        // Insert categories and tags
        $sql_recipe_tag = "INSERT INTO recipe_tag (recipe_id, category_id, vegan, vegetarian, gluten_free) 
                           VALUES (?, ?, ?, ?, ?)";
        $stmt_recipe_tag = $conn->prepare($sql_recipe_tag);
        if (!$stmt_recipe_tag) {
            throw new Exception("Prepare failed for recipe_tag: " . $conn->error);
        }

        if (isset($_POST["categories"]) && is_array($_POST["categories"])) {
            foreach ($_POST["categories"] as $category_id) {
                $category_id = sanitize_input($category_id);
                $dummy_tag = null;
                $stmt_recipe_tag->bind_param("iiiii", $recipe_id, $category_id, $vegan, $vegetarian, $gluten_free);
                if (!$stmt_recipe_tag->execute()) {
                    throw new Exception("Execute failed for category: " . $stmt_recipe_tag->error);
                }
            }
        }

        $stmt_recipe_tag->close();

            // Commit transaction
            $conn->commit();
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            }
}

// Close connection
$conn->close();
?>

<!doctype html>
<html lang="en">
<!-- Design by Euan Steven -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Recipes">
  <meta name="author" content="Euan Steven">

  <title>Recipe Manager | Create</title>

  <meta property="og:title" content="Recipe Manager | Create">
  <meta property="og:type" content="website">
  <meta property="og:image" content="/assets/images/covers/create_cover.jpg">
  <meta property="og:description" content="Create">
  <meta property="og:locale" content="en_GB">

  <link rel="icon" href="/assets/icons/favicon.ico sizes="any">
  <link rel="icon" href="/assets/icons/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/assets/icons/icon.png">

  <link rel="stylesheet" href="/assets/css/main.css">
  
  <script src="/assets/js/main.js"></script>

  <style>
        body {
            background-color: #111111;
            color: #ffffff;
            font-family: 'Space Mono', monospace;
            margin: 0;
            padding: 0;
        }
        .recipe-create-form {
            color: #a19a9a;
            padding: 5%;
            margin-left: 10%;
            margin-right: 10%;
            padding-top: 2%;
        }
        .recipe-create-form h2 {
            color: #25b747;
            margin-bottom: 1em;
        }
        .form-group {
            margin-bottom: 1em;
        }
        label {
            display: block;
            margin-bottom: 0.5em;
        }
        input, textarea, select {
            width: 100%;
            padding: 0.5em;
            border: none;
            border-radius: 4px;
            background-color: #242424;
            color: #ffffff;
            font-family: 'Space Mono', monospace;
        }

        button[type="submit"] {
            background-color: #25b747;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 0.5em 1em;
            cursor: pointer;
            font-family: 'Space Mono', monospace;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #1e9037;
        }
        .error {
            color: #ff4d4d;
            margin-bottom: 1em;
        }
        .success {
            color: #25b747;
            margin-bottom: 1em;
        }
        .add-ingredient, .add-media {
            margin-bottom: 1em;
        }
        .ingredient-group, .media-group {
            display: flex;
            gap: 10px;
            margin-bottom: 0.5em;
        }
        .ingredient-group input, .media-group input {
            flex: 1;
        }
  </style>
</head>

<body>
  <div class="intro">
    <h1>Recipe Manager</h1>
    <h2>// Create</h2>
    <div class="back-button">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#A19a9a">
        <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/>
      </svg>
      <span><a class="back" href="/index.php">Back</a></span>
    </div>
  </div>

  <div class="recipe-create-form">
    <form action="create.php" method="POST">
        <!-- Recipe Name -->
        <div class="form-group">
            <label for="recipe_name">Recipe Name</label>
            <input type="text" id="recipe_name" name="recipe_name" required>
        </div>

        <!-- Serving Size -->
        <div class="form-group">
            <label for="serving_size">Serving Size</label>
            <input type="text" id="serving_size" name="serving_size" required>
        </div>

        <!-- Cooking Time -->
        <div class="form-group">
            <label for="cooking_time">Cooking Time (in minutes)</label>
            <input type="number" id="cooking_time" name="cooking_time" min="1" required>
        </div>

        <!-- Directions -->
        <div class="form-group">
            <label for="directions">Directions</label>
            <textarea id="directions" name="directions" rows="5" required></textarea>
        </div>

        <!-- Categories -->
        <div class="form-group">
            <label for="categories">Category</label>
            <select id="categories" name="categories[]" multiple>
                <?php
                // Fetch categories from the database
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql_cat = "SELECT category_id, category_name FROM categories";
                $result_cat = $conn->query($sql_cat);
                if ($result_cat->num_rows > 0) {
                    while($row = $result_cat->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['category_id']) . "'>" . htmlspecialchars($row['category_name']) . "</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
        </div>

        <!-- Dietary Information -->
        <div class="form-group">
            <label>Dietary Information</label>
            <label for="vegan">
              <input type="checkbox" style="float: left;" id="vegan" name="vegan">
              <div style="overflow: hidden; padding: 4px 0px 0px 5px;">Vegan</div>
            </label><br>
            <label for="vegetarian">
              <input type="checkbox" style="float: left;" id="vegetarian" name="vegetarian">
              <div style="overflow: hidden; padding: 4px 0px 0px 5px;">Vegetarian</div>
            </label><br>
            <label for="gluten_free">
              <input type="checkbox" style="float: left;" id="gluten_free" name="gluten_free">
              <div style="overflow: hidden; padding: 4px 0px 0px 5px;">Gluten Free</div>
            </label>
        </div>

        <!-- Ingredients -->
        <div class="form-group">
            <label>Ingredients</label>
            <div id="ingredients">
                <div class="ingredient-group">
                    <input type="text" name="ingredient_name[]" placeholder="Ingredient Name" required>
                    <input type="number" name="quantity[]" step="0.01" placeholder="Quantity" required>
                    <input type="text" name="unit[]" placeholder="Unit" required>
                </div>
            </div>
            <button type="button" class="add-ingredient" onclick="addIngredient()">Add Another Ingredient</button>
        </div>

        <!-- Media Links -->
        <div class="form-group">
            <label>Media Link</label>
            <div id="media_links">
                <div class="media-group">
                    <input type="url" name="media_link[]" placeholder="Media URL" required>
                </div>
            </div>
        </div>

        <!-- Nutrition Information -->
        <div class="form-group">
            <label>Nutrition Information</label>
            <input class="nutrition" type="number" name="kcal" placeholder="Calories (kcal)" required>
            <input class="nutrition" type="number" name="protein" placeholder="Protein (g)" required>
            <input class="nutrition" type="number" name="carbs" placeholder="Carbohydrates (g)" required>
            <input class="nutrition" type="number" name="fat" placeholder="Fat (g)" required>
            <input class="nutrition" type="number" name="sugar" placeholder="Sugar (g)" required>
        </div>

        <!-- Submit Button -->
        <button type="submit">Submit Recipe</button>
    </form>
</div>

<!-- JavaScript to add more ingredients and media links -->
<script>
    function addIngredient() {
        const ingredientsDiv = document.getElementById('ingredients');
        const newIngredient = document.createElement('div');
        newIngredient.classList.add('ingredient-group');
        newIngredient.innerHTML = `
            <input type="text" name="ingredient_name[]" placeholder="Ingredient Name" required>
            <input type="number" name="quantity[]" step="0.01" placeholder="Quantity" required>
            <input type="text" name="unit[]" placeholder="unit" required>
        `;
        ingredientsDiv.appendChild(newIngredient);
    }

    function addMedia() {
        const mediaDiv = document.getElementById('media_links');
        const newMedia = document.createElement('div');
        newMedia.classList.add('media-group');
        newMedia.innerHTML = `
            <input type="url" name="media_link[]" placeholder="Media URL" required>
        `;
        mediaDiv.appendChild(newMedia);
    }
</script>

  <footer>
    <p>© <script>document.write(new Date().getFullYear())</script> Euan Steven</p>
  </footer>

</body>

</html>