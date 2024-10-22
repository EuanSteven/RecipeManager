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
// Fetch recipe details
$sql = "
SELECT r.recipe_id, r.recipe_name, r.directions, rt.vegan, rt.vegetarian, rt.gluten_free, m.media_link, c.category_name, r.cooking_time, r.serving_size, n.kcal AS calories, n.protein, n.carbs, n.fat, n.sugar
FROM recipes r
LEFT JOIN recipe_tag rt USING (recipe_id)
LEFT JOIN categories c ON rt.category_id = c.category_id
LEFT JOIN media m USING (recipe_id)
LEFT JOIN nutrition n USING (recipe_id)
WHERE r.recipe_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $recipe = $result->fetch_assoc();
} else {
    echo "Recipe not found.";
    exit();
}

// Fetch ingredients
$sql_ingredients = "
SELECT i.ingredient_name, m.quantity, m.unit
FROM measurements m
JOIN ingredients i ON m.ingredient_id = i.ingredient_id
WHERE m.recipe_id = ?
";

$stmt_ingredients = $conn->prepare($sql_ingredients);
$stmt_ingredients->bind_param("i", $recipe_id);
$stmt_ingredients->execute();
$result_ingredients = $stmt_ingredients->get_result();

$ingredients = [];
while ($row = $result_ingredients->fetch_assoc()) {
    $ingredients[] = $row;
}

// Close database connection
$stmt->close();
$stmt_ingredients->close();
$conn->close();

// Helper function to generate dietary labels
function getDietaryLabels($recipe) {
    $labels = [];
    if (!empty($recipe['vegan'])) $labels[] = "V";
    if (!empty($recipe['vegetarian'])) $labels[] = "Vg";
    if (!empty($recipe['gluten_free'])) $labels[] = "GF";
    return implode("/", $labels);
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo htmlspecialchars($recipe['recipe_name'] ?? ''); ?>">
  <meta name="author" content="Euan Steven">

  <title><?php echo htmlspecialchars($recipe['recipe_name'] ?? ''); ?></title>

  <meta property="og:title" content="<?php echo htmlspecialchars($recipe['recipe_name'] ?? ''); ?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php echo htmlspecialchars($recipe['media_link'] ?? ''); ?>">
  <meta property="og:description" content="Recipes">
  <meta property="og:locale" content="en_GB">

  <link rel="icon" type="image/x-icon" href="/assets/img/icons/favicon.ico">
  <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>

  <div class="recipe-container">
    <div class="left-column">
        <img src="<?php echo htmlspecialchars($recipe['media_link'] ?? ''); ?>" alt="Recipe Image" class="pagerecipe-image">
        <div class="ingredients-box">
        <h2>Ingredients</h2>
        <ul>
            <?php foreach ($ingredients as $ingredient): ?>
                <li><?php echo htmlspecialchars($ingredient['quantity'] ?? '') . " " . htmlspecialchars($ingredient['unit'] ?? '') . " " . htmlspecialchars($ingredient['ingredient_name'] ?? ''); ?></li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>

    <div class="right-column">
      <div class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#A19a9a">
          <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/>
        </svg>
        <span><a class="back" href="/index.php">Back</a></span>
      </div>
      <div class="info-box">
        <div class="recipe-header">
            <span class="category">
              <?php 
              echo htmlspecialchars($recipe['category_name'] ?? ''); 
              if (!empty(getDietaryLabels($recipe))) {
                  echo " | " . getDietaryLabels($recipe);
              }
              ?>
            </span>
        </div>
        <h3 class="recipe-title"><a class="recipelink" href="/pages/recipes/pages/recipe<?php echo htmlspecialchars($recipe['recipe_id'] ?? ''); ?>.html"><?php echo htmlspecialchars($recipe['recipe_name'] ?? ''); ?></a></h3>

        <div class="recipe-meta">
          <span class="cooking-time">
            <svg width="13" height="13" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11.97 13.23L13.23 11.97L9.9 8.64V4.5H8.1V9.36L11.97 13.23ZM9 18C7.755 18 6.585 17.7638 5.49 17.2913C4.395 16.8188 3.4425 16.1775 2.6325 15.3675C1.8225 14.5575 1.18125 13.605 0.70875 12.51C0.23625 11.415 0 10.245 0 9C0 7.755 0.23625 6.585 0.70875 5.49C1.18125 4.395 1.8225 3.4425 2.6325 2.6325C3.4425 1.8225 4.395 1.18125 5.49 0.70875C6.585 0.23625 7.755 0 9 0C10.245 0 11.415 0.23625 12.51 0.70875C13.605 1.18125 14.5575 1.8225 15.3675 2.6325C16.1775 3.4425 16.8188 4.395 17.2913 5.49C17.7638 6.585 18 7.755 18 9C18 10.245 17.7638 11.415 17.2913 12.51C16.8188 13.605 16.1775 14.5575 15.3675 15.3675C14.5575 16.1775 13.605 16.8188 12.51 17.2913C11.415 17.7638 10.245 18 9 18ZM9 16.2C10.995 16.2 12.6938 15.4988 14.0963 14.0963C15.4988 12.6938 16.2 10.995 16.2 9C16.2 7.005 15.4988 5.30625 14.0963 3.90375C12.6938 2.50125 10.995 1.8 9 1.8C7.005 1.8 5.30625 2.50125 3.90375 3.90375C2.50125 5.30625 1.8 7.005 1.8 9C1.8 10.995 2.50125 12.6938 3.90375 14.0963C5.30625 15.4988 7.005 16.2 9 16.2Z" fill="#A19A9A"/>
            </svg>
            <span><?php echo htmlspecialchars($recipe['cooking_time'] ?? ''); ?> Minutes</span>
          </span>
          <span class="serving-size">
            <svg width="13" height="13" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.368 12.1146C15.8591 13.3185 15.0631 14.3793 14.0496 15.2044C13.0361 16.0294 11.8359 16.5936 10.5541 16.8475C9.27224 17.1015 7.94772 17.0375 6.69633 16.6611C5.44493 16.2847 4.30476 15.6075 3.37549 14.6885C2.44622 13.7696 1.75616 12.6369 1.36562 11.3896C0.975088 10.1422 0.895974 8.81821 1.1352 7.53323C1.37442 6.24824 1.9247 5.04144 2.73792 4.01832C3.55115 2.9952 4.60256 2.18692 5.80023 1.66414M17 9.00187C17 7.95105 16.7931 6.91052 16.391 5.93969C15.989 4.96886 15.3998 4.08674 14.6569 3.34369C13.914 2.60065 13.0322 2.01124 12.0616 1.60911C11.091 1.20697 10.0507 1 9.00016 1V9.00187H17Z" stroke="#A19A9A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Serves <?php echo htmlspecialchars($recipe['serving_size'] ?? ''); ?></span>
          </span>
        </div>

        <hr class="divider">

        <div class="nutrition-info">
            <div class="nutrition-item">
                <span class="nutrition-value"><?php echo htmlspecialchars($recipe['calories'] ?? ''); ?></span>
                <span class="nutrition-label">kcal</span>
            </div>
            <div class="nutrition-item">
                <span class="nutrition-value"><?php echo htmlspecialchars($recipe['protein'] ?? ''); ?>g</span>
                <span class="nutrition-label">protein</span>
            </div>
            <div class="nutrition-item">
              <span class="nutrition-value"><?php echo htmlspecialchars($recipe['carbs'] ?? ''); ?>g</span>
              <span class="nutrition-label">carbs</span>
            </div>
            <div class="nutrition-item">
                <span class="nutrition-value"><?php echo htmlspecialchars($recipe['fat'] ?? ''); ?>g</span>
                <span class="nutrition-label">fat</span>
            </div>
            <div class="nutrition-item">
              <span class="nutrition-value"><?php echo htmlspecialchars($recipe['sugar'] ?? ''); ?>g</span>
              <span class="nutrition-label">sugar</span>
            </div>
        </div>
      </div>
        <div class="method-box">
            <h2>Method</h2>
            <div class="step">
              <p><?php echo nl2br(htmlspecialchars($recipe['directions'] ?? '')); ?></p>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>