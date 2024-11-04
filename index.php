<?php
    // Fetch Database Connection Variables from .env
    $servername = $_ENV['SERVERNAME'];
    $username = $_ENV['USERNAME'];
    $password = $_ENV['PASSWORD'];
    $dbname = $_ENV['DBNAME'];
    $port = $_ENV['PORT'];
    
    // Start Connection to Database
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // If Connection Fails, Display Error Message
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Query to Fetch Recipe Data
    $sql = "
    SELECT r.recipe_id, r.recipe_name, r.cooking_time, r.serving_size, 
            c.category_name, rt.vegan, rt.vegetarian, rt.gluten_free, m.media_link
    FROM recipes r
    LEFT JOIN media m ON r.recipe_id = m.recipe_id
    LEFT JOIN recipe_tag rt ON r.recipe_id = rt.recipe_id
    LEFT JOIN categories c ON rt.category_id = c.category_id
    ";
    $result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<!-- Design by Euan Steven -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Recipes">
  <meta name="author" content="Euan Steven">

  <title>Recipe Manager</title>

  <meta property="og:title" content="Recipe Manager">
  <meta property="og:type" content="website">
  <meta property="og:image" content="/assets/img/covers/index.png">
  <meta property="og:description" content="Recipes">
  <meta property="og:locale" content="en_GB">

  <link rel="icon" type="image/x-icon" href="/assets/img/icons/favicon.ico">
  <link rel="stylesheet" href="/assets/css/main.css">
</head>

<body>
  <div class="intro">
    <h1>Recipe Manager</h1>
    <h2>// Home Page</h2>
  </div>

  <div class="add">
    <button class="w3-btn w3-white w3-border w3-border-green w3-round-xxlarge">
      <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="20px" fill="#a19a9a">
        <path d="M216-216h51l375-375-51-51-375 375v51Zm-72 72v-153l549-549 153 153-549 549H144Zm600-549-51-51 51 51Zm-127.95 76.95L591-642l51 51-25.95-25.05Z"/>
      </svg>
      <a href="/pages/create.php" class="recipe-buttons">Create</a>
    </button>
  </div>
  
  <div class="search-container">
    <div class="search">
        <div class="searchlabel">
            <input type="text" id="searchInput" class="searchTerm" placeholder="Search">
        </div>
    </div>

    <div class="dropdown">
        <button class="icon-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a19a9a">
            <path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z"/>
        </svg>
        <div class="dropdown-content">
            <span class="sortby">Sort By
            <svg width="10" height="10" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="sort-indicator" data-order="asc">
                <path d="M5.25 2.86875L1.05 7.06875L0 6L6 0L12 6L10.95 7.06875L6.75 2.86875V12L5.25 12L5.25 2.86875Z" fill="#A19A9A" class="asc-arrow"/>
                <path d="M11.25 19.1313L7.05 14.9313L6 16L12 22L18 16L16.95 14.9312L12.75 19.1313L12.75 10H11.25L11.25 19.1313Z" fill="#A19A9A" class="desc-arrow"/>
            </svg>
            </span>
            <span class="option" data-sort="name"><a href="#">Recipe Name</a></span>
            <span class="option" data-sort="time"><a href="#">Cooking Time</a></span>
            <span class="option" data-sort="size"><a href="#">Serving Size</a></span>
        </div>
        </button>
    </div>
  </div>

  <div class="recipe-list">
      <?php
      if ($result->num_rows > 0) {
          // Output data for each recipe
          while($row = $result->fetch_assoc()) {
              $recipeId = $row["recipe_id"];
              $title = htmlspecialchars($row["recipe_name"]);
              $category = htmlspecialchars($row["category_name"]);
              $cookingTime = htmlspecialchars($row["cooking_time"]);
              $servingSize = htmlspecialchars($row["serving_size"]);
              $imageUrl = htmlspecialchars($row["media_link"]);
              
              // Determine dietary labels
              $dietLabels = array();
              if ($row["vegan"]) $dietLabels[] = "V";
              elseif ($row["vegetarian"]) $dietLabels[] = "Vg";
              if ($row["gluten_free"]) $dietLabels[] = "GF";
              $dietLabelString = implode("/", $dietLabels);
              ?>
              <div class="recipe">
                  <a href="/pages/recipe.php?id=<?php echo $recipeId; ?>">
                      <img src="<?php echo $imageUrl; ?>" alt="<?php echo $title; ?>" class="recipe-image">
                  </a>
                  <div class="recipe-details">
                      <div class="recipe-header">
                          <span class="category">
                            <?php 
                            echo $category; 
                            if (!empty($dietLabelString)) {
                                echo " | " . $dietLabelString;
                            }
                            ?>
                          </span>
                      </div>
                      <h3 class="recipe-title">
                          <a class="recipelink" href="/pages/recipe.php?id=<?php echo $recipeId; ?>">
                              <?php echo $title; ?>
                          </a>
                      </h3>
                      <div class="recipe-meta">
                          <span class="cooking-time">
                            <svg width="13" height="13" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.97 13.23L13.23 11.97L9.9 8.64V4.5H8.1V9.36L11.97 13.23ZM9 18C7.755 18 6.585 17.7638 5.49 17.2913C4.395 16.8188 3.4425 16.1775 2.6325 15.3675C1.8225 14.5575 1.18125 13.605 0.70875 12.51C0.23625 11.415 0 10.245 0 9C0 7.755 0.23625 6.585 0.70875 5.49C1.18125 4.395 1.8225 3.4425 2.6325 2.6325C3.4425 1.8225 4.395 1.18125 5.49 0.70875C6.585 0.23625 7.755 0 9 0C10.245 0 11.415 0.23625 12.51 0.70875C13.605 1.18125 14.5575 1.8225 15.3675 2.6325C16.1775 3.4425 16.8188 4.395 17.2913 5.49C17.7638 6.585 18 7.755 18 9C18 10.245 17.7638 11.415 17.2913 12.51C16.8188 13.605 16.1775 14.5575 15.3675 15.3675C14.5575 16.1775 13.605 16.8188 12.51 17.2913C11.415 17.7638 10.245 18 9 18ZM9 16.2C10.995 16.2 12.6938 15.4988 14.0963 14.0963C15.4988 12.6938 16.2 10.995 16.2 9C16.2 7.005 15.4988 5.30625 14.0963 3.90375C12.6938 2.50125 10.995 1.8 9 1.8C7.005 1.8 5.30625 2.50125 3.90375 3.90375C2.50125 5.30625 1.8 7.005 1.8 9C1.8 10.995 2.50125 12.6938 3.90375 14.0963C5.30625 15.4988 7.005 16.2 9 16.2Z" fill="#A19A9A"/>
                            </svg>
                            <?php echo $cookingTime; ?> Minutes
                          </span>
                      </div>
                      <div class="recipe-meta">
                          <span class="serving-size">
                              <svg width="13" height="13" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.368 12.1146C15.8591 13.3185 15.0631 14.3793 14.0496 15.2044C13.0361 16.0294 11.8359 16.5936 10.5541 16.8475C9.27224 17.1015 7.94772 17.0375 6.69633 16.6611C5.44493 16.2847 4.30476 15.6075 3.37549 14.6885C2.44622 13.7696 1.75616 12.6369 1.36562 11.3896C0.975088 10.1422 0.895974 8.81821 1.1352 7.53323C1.37442 6.24824 1.9247 5.04144 2.73792 4.01832C3.55115 2.9952 4.60256 2.18692 5.80023 1.66414M17 9.00187C17 7.95105 16.7931 6.91052 16.391 5.93969C15.989 4.96886 15.3998 4.08674 14.6569 3.34369C13.914 2.60065 13.0322 2.01124 12.0616 1.60911C11.091 1.20697 10.0507 1 9.00016 1V9.00187H17Z" stroke="#A19A9A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                              <?php echo $servingSize; ?> Servings
                          </span>
                      </div>
                  </div>
              </div>
              <?php
          }
      } else {
          echo "<p>No Recipes Found.</p>";
      }
      $conn->close();
      ?>
  </div>

  <div class="paginationcenter">
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=1">
                <svg width="24" height="12" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.65375 19.3075L0 9.65375L9.65375 0L11.073 1.41925L2.83825 9.65375L11.073 17.8883L9.65375 19.3075Z" fill="#A19A9A"/>
                    <path d="M21.65375 19.3075L12 9.65375L21.65375 0L23.073 1.41925L14.83825 9.65375L23.073 17.8883L21.65375 19.3075Z" fill="#A19A9A"/>
                </svg>
            </a>
            <a href="?page=<?php echo $page - 1; ?>">
                <svg width="12" height="12" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.65375 19.3075L0 9.65375L9.65375 0L11.073 1.41925L2.83825 9.65375L11.073 17.8883L9.65375 19.3075Z" fill="#A19A9A"/>
                </svg>
            </a>
        <?php endif; ?>

        <?php
        $startPage = max(1, $page - 1);
        $endPage = min($totalPages, $page + 1);
        for ($i = $startPage; $i <= $endPage; $i++):
        ?>
            <a href="?page=<?php echo $i; ?>" <?php echo ($i == $page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">
                <svg width="12" height="12" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.41925 19.3075L11.073 9.65375L1.41925 0L-1.90735e-06 1.41925L8.23475 9.65375L-1.90735e-06 17.8883L1.41925 19.3075Z" fill="#A19A9A"/>
                </svg>
            </a>
            <a href="?page=<?php echo $totalPages; ?>">
                <svg width="24" height="12" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.34625 0L12 9.65375L2.34625 19.3075L0.927 17.8883L9.16175 9.65375L0.927 1.41925L2.34625 0Z" fill="#A19A9A"/>
                    <path d="M14.34625 0L24 9.65375L14.34625 19.3075L12.927 17.8883L21.16175 9.65375L12.927 1.41925L14.34625 0Z" fill="#A19A9A"/>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const recipeList = document.querySelector('.recipe-list');
    const pagination = document.querySelector('.pagination');
    let currentPage = 1;
    let recipesPerPage = 10;

    // Function to perform the search
    function searchRecipes() {
        const filter = searchInput.value.toUpperCase();
        const recipes = document.getElementsByClassName('recipe');
        let visibleCount = 0;

        for (let i = 0; i < recipes.length; i++) {
            const recipe = recipes[i];
            const title = recipe.getElementsByClassName('recipe-title')[0];
            const category = recipe.getElementsByClassName('category')[0];
            const txtValue = title.textContent || title.innerText;
            const categoryValue = category.textContent || category.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1 || categoryValue.toUpperCase().indexOf(filter) > -1) {
                recipe.style.display = "";
                visibleCount++;
            } else {
                recipe.style.display = "none";
            }
        }

        updatePagination(visibleCount);
    }

    // Function to sort recipes
    function sortRecipes(sortBy, order) {
        const recipes = Array.from(recipeList.getElementsByClassName('recipe'));

        recipes.sort((a, b) => {
            let aValue, bValue;

            switch (sortBy) {
                case 'name':
                    aValue = a.querySelector('.recipe-title').textContent.trim().toLowerCase();
                    bValue = b.querySelector('.recipe-title').textContent.trim().toLowerCase();
                    break;
                case 'time':
                    aValue = parseInt(a.querySelector('.cooking-time').textContent);
                    bValue = parseInt(b.querySelector('.cooking-time').textContent);
                    break;
                case 'size':
                    aValue = parseInt(a.querySelector('.serving-size').textContent);
                    bValue = parseInt(b.querySelector('.serving-size').textContent);
                    break;
            }

            if (order === 'asc') {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });

        recipes.forEach(recipe => recipeList.appendChild(recipe));
        updatePagination(recipes.length);
    }

    // Function to update pagination
    function updatePagination(totalRecipes) {
        const totalPages = Math.ceil(totalRecipes / recipesPerPage);
        let paginationHTML = '';

        if (currentPage > 1) {
            paginationHTML += `<a href="#" data-page="1">&laquo;</a>`;
            paginationHTML += `<a href="#" data-page="${currentPage - 1}">&lsaquo;</a>`;
        }

        const startPage = Math.max(1, currentPage - 1);
        const endPage = Math.min(totalPages, currentPage + 1);

        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `<a href="#" data-page="${i}" ${i === currentPage ? 'class="active"' : ''}>${i}</a>`;
        }

        if (currentPage < totalPages) {
            paginationHTML += `<a href="#" data-page="${currentPage + 1}">&rsaquo;</a>`;
            paginationHTML += `<a href="#" data-page="${totalPages}">&raquo;</a>`;
        }

        pagination.innerHTML = paginationHTML;
        addPaginationListeners();
    }

    // Function to add event listeners to pagination links
    function addPaginationListeners() {
        const paginationLinks = pagination.querySelectorAll('a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = parseInt(this.getAttribute('data-page'));
                displayRecipes();
            });
        });
    }

    // Function to display recipes for the current page
    function displayRecipes() {
        const recipes = document.getElementsByClassName('recipe');
        const startIndex = (currentPage - 1) * recipesPerPage;
        const endIndex = startIndex + recipesPerPage;

        for (let i = 0; i < recipes.length; i++) {
            if (i >= startIndex && i < endIndex) {
                recipes[i].style.display = "";
            } else {
                recipes[i].style.display = "none";
            }
        }

        updatePagination(recipes.length);
    }

    // Add event listeners
    searchInput.addEventListener('keyup', searchRecipes);

    const sortOptions = document.querySelectorAll('.option');
    const sortIndicator = document.querySelector('.sort-indicator');
    let currentSortBy = 'name';
    let currentOrder = 'asc';

    sortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const newSortBy = this.getAttribute('data-sort');
            
            if (newSortBy === currentSortBy) {
                currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
            } else {
                currentOrder = 'asc';
                currentSortBy = newSortBy;            }

            sortIndicator.setAttribute('data-order', currentOrder);
            sortIndicator.querySelector('.asc-arrow').style.fill = currentOrder === 'asc' ? '#A19A9A' : '#E0E0E0';
            sortIndicator.querySelector('.desc-arrow').style.fill = currentOrder === 'desc' ? '#A19A9A' : '#E0E0E0';

            sortRecipes(currentSortBy, currentOrder);
            sortOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Initial display
    displayRecipes();
});
</script>
</body>
</html>