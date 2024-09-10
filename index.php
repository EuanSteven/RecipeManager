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
  <meta property="og:image" content="/assets/images/covers/recipes_cover.jpg">
  <meta property="og:description" content="Recipes">
  <meta property="og:locale" content="en_GB">

  <link rel="icon" href="/assets/icons/favicon.ico sizes="any">
  <link rel="icon" href="/assets/icons/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/assets/icons/icon.png">

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
      <a href="/pages/create.php" class="recipe_buttons">Create</a>
    </button>
    <button class="w3-btn w3-white w3-border w3-border-green w3-round-xlarge">
      <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="20px" fill="#a19a9a">
        <path d="M432-288H288q-79.68 0-135.84-56.23Q96-400.45 96-480.23 96-560 152.16-616q56.16-56 135.84-56h144v72H288q-50 0-85 35t-35 85q0 50 35 85t85 35h144v72Zm-96-156v-72h288v72H336Zm192 156v-72h144q50 0 85-35t35-85q0-50-35-85t-85-35H528v-72h144q79.68 0 135.84 56.23 56.16 56.22 56.16 136Q864-400 807.84-344 751.68-288 672-288H528Z"/>
      </svg>
      <a href="/pages/import.php" class="recipe_buttons">Import</a>
    </button>
    <button class="w3-btn w3-white w3-border w3-border-green w3-round-xlarge">
      <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="20px" fill="#a19a9a">
        <path d="M96-720v-192h192v72H168v120H96Zm696 0v-120H672v-72h192v192h-72ZM96-48v-192h72v120h120v72H96Zm576 0v-72h120v-120h72v192H672ZM312-264h336v-432H312v432Zm-72 72v-576h480v576H240Zm144-360h192v-72H384v72Zm0 108h192v-72H384v72Zm0 108h192v-72H384v72Zm-72 72v-432 432Z"/>
      </svg>
      <a href="/pages/scan.php" class="recipe_buttons">Scan</a>
    </button>
  </div>
  
  <div class="search-container">
    <div class="search">
      <searchlabel>
        <input type="text" class="searchTerm" placeholder="Search">
      </searchlabel>
    </div>

    <div class="dropdown">
      <button class="icon-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a19a9a"><path d="M440-120v-240h80v80h320v80H520v80h-80Zm-320-80v-80h240v80H120Zm160-160v-80H120v-80h160v-80h80v240h-80Zm160-80v-80h400v80H440Zm160-160v-240h80v80h160v80H680v80h-80Zm-480-80v-80h400v80H120Z"/></svg>
        <div class="dropdown-content">
          <span class="filteroption">Category
              <svg width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.97368 12.6L12.7895 0L20.6053 12.6H4.97368ZM20.6053 28C18.8289 28 17.3191 27.3875 16.0757 26.1625C14.8322 24.9375 14.2105 23.45 14.2105 21.7C14.2105 19.95 14.8322 18.4625 16.0757 17.2375C17.3191 16.0125 18.8289 15.4 20.6053 15.4C22.3816 15.4 23.8914 16.0125 25.1349 17.2375C26.3783 18.4625 27 19.95 27 21.7C27 23.45 26.3783 24.9375 25.1349 26.1625C23.8914 27.3875 22.3816 28 20.6053 28ZM0 27.3V16.1H11.3684V27.3H0ZM20.6053 25.2C21.6 25.2 22.4408 24.8617 23.1276 24.185C23.8145 23.5083 24.1579 22.68 24.1579 21.7C24.1579 20.72 23.8145 19.8917 23.1276 19.215C22.4408 18.5383 21.6 18.2 20.6053 18.2C19.6105 18.2 18.7697 18.5383 18.0829 19.215C17.3961 19.8917 17.0526 20.72 17.0526 21.7C17.0526 22.68 17.3961 23.5083 18.0829 24.185C18.7697 24.8617 19.6105 25.2 20.6053 25.2ZM2.84211 24.5H8.52632V18.9H2.84211V24.5ZM10.0184 9.8H15.5605L12.7895 5.39L10.0184 9.8Z" fill="#A19A9A"/>
              </svg>
          </span>
          
          <form class="categoryoptions" action="/action_page.php">
            <label for="dinner">
              <input type="checkbox" style="float: left;" id="Dinner" name="dinner" value="Dinner">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Dinner</div>
            </label><br>
            <label for="breakfast">
              <input type="checkbox" style="float: left;" id="Breakfast" name="breakfast" value="Breakfast">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Breakfast</div>
            </label><br>
            <label for="dessert">
              <input type="checkbox" style="float: left;" id="Dessert" name="dessert" value="Dessert">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Dessert</div>
            </label><br>
          </form>

          <span class="filteroption">Foods
              <svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 30.2399C18.5 30.2399 16.375 29.3649 14.625 27.6149C12.875 25.8649 12 23.7399 12 21.2399C12 18.7399 12.875 16.6149 14.625 14.8649C16.375 13.1149 18.5 12.2399 21 12.2399C23.5 12.2399 25.625 13.1149 27.375 14.8649C29.125 16.6149 30 18.7399 30 21.2399C30 23.7399 29.125 25.8649 27.375 27.6149C25.625 29.3649 23.5 30.2399 21 30.2399ZM21 27.2399C22.65 27.2399 24.0625 26.6524 25.2375 25.4774C26.4125 24.3024 27 22.8899 27 21.2399C27 19.5899 26.4125 18.1774 25.2375 17.0024C24.0625 15.8274 22.65 15.2399 21 15.2399C19.35 15.2399 17.9375 15.8274 16.7625 17.0024C15.5875 18.1774 15 19.5899 15 21.2399C15 22.8899 15.5875 24.3024 16.7625 25.4774C17.9375 26.6524 19.35 27.2399 21 27.2399ZM0 27.2399V12.1649L3.225 4.73993H1.5V0.239929H15V4.73993H13.275L15.75 10.4399C15.275 10.6899 14.825 10.9524 14.4 11.2274C13.975 11.5024 13.575 11.8149 13.2 12.1649L10.05 4.73993H6.45L3 12.8399V24.2399H9.375C9.5 24.7649 9.66875 25.2837 9.88125 25.7962C10.0938 26.3087 10.35 26.7899 10.65 27.2399H0ZM21 10.7399C19.95 10.7399 19.0625 10.3774 18.3375 9.65243C17.6125 8.92743 17.25 8.03993 17.25 6.98993C17.25 5.93993 17.6125 5.05243 18.3375 4.32743C19.0625 3.60243 19.95 3.23993 21 3.23993V10.7399C21 9.68993 21.3625 8.80243 22.0875 8.07743C22.8125 7.35243 23.7 6.98993 24.75 6.98993C25.8 6.98993 26.6875 7.35243 27.4125 8.07743C28.1375 8.80243 28.5 9.68993 28.5 10.7399H21Z" fill="#A19A9A"/>
              </svg>
          </span>

          <div class="filtersearch">
            <filtersearchlabel>
              <input type="text" class="filtersearchTerm" placeholder="Search">
            </filtersearchlabel>
          </div>

          <form class="categoryoptions" action="/action_page.php">
            <label for="beef">
              <input type="checkbox" style="float: left;" id="Beef" name="beef" value="Beef">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Beef</div>
            </label><br>
            <label for="chicken">
              <input type="checkbox" style="float: left;" id="Chicken" name="chicken" value="Chicken">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Chicken</div>
            </label><br>
            <label for="rice">
              <input type="checkbox" style="float: left;" id="Rice" name="rice" value="Rice">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Rice</div>
            </label><br>
          </form>

          <span class="filteroption">Dietary
              <svg width="24" height="24" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.954 24.0453C2.71837 22.8094 1.75047 21.3813 1.05028 19.761C0.350094 18.1406 0 16.4654 0 14.7352C0 13.005 0.3295 11.2954 0.9885 9.60638C1.6475 7.91738 2.71837 6.33137 4.20112 4.84835C5.16216 3.88713 6.34974 3.06323 7.76384 2.37664C9.17794 1.69006 10.8529 1.14765 12.7887 0.749434C14.7245 0.351215 16.9349 0.11091 19.4199 0.0285197C21.9049 -0.0538705 24.685 0.0422514 27.7604 0.316885C27.98 3.22801 28.0487 5.90569 27.9663 8.34993C27.8839 10.7942 27.6574 12.9981 27.2867 14.9617C26.916 16.9254 26.3943 18.6418 25.7216 20.1111C25.0489 21.5804 24.2182 22.8094 23.2297 23.7981C21.7745 25.2537 20.2299 26.3179 18.5961 26.9907C16.9624 27.6636 15.2943 28 13.5919 28C11.8071 28 10.0635 27.6498 8.36106 26.9495C6.65864 26.2492 5.18962 25.2811 3.954 24.0453ZM8.567 23.3861C9.36329 23.853 10.1802 24.1895 11.0177 24.3954C11.8551 24.6014 12.7132 24.7044 13.5919 24.7044C14.855 24.7044 16.1043 24.4504 17.3399 23.9423C18.5756 23.4342 19.7563 22.6172 20.8821 21.4912C21.3763 20.9968 21.8774 20.3034 22.3854 19.4108C22.8934 18.5183 23.3327 17.3511 23.7034 15.9092C24.0741 14.4674 24.3555 12.7235 24.5477 10.6775C24.7399 8.63143 24.7674 6.19405 24.6301 3.36532C23.2847 3.3104 21.7676 3.2898 20.0789 3.30353C18.3902 3.31726 16.7084 3.44771 15.0334 3.69488C13.3585 3.94205 11.7659 4.34027 10.2557 4.88954C8.74548 5.43881 7.50985 6.19405 6.54881 7.15527C5.31319 8.39113 4.46198 9.61325 3.99519 10.8216C3.52839 12.03 3.295 13.1972 3.295 14.3232C3.295 15.9436 3.6039 17.3648 4.22172 18.5869C4.83953 19.809 5.38183 20.6673 5.84862 21.1616C7.00187 18.9645 8.52581 16.8567 10.4204 14.8382C12.3151 12.8196 14.5255 11.1649 17.0516 9.87415C15.0746 11.6043 13.3516 13.5611 11.8826 15.7445C10.4136 17.9278 9.30837 20.475 8.567 23.3861Z" fill="#A19A9A"/>
              </svg>
          </span>

          <form class="categoryoptions" action="/action_page.php">
            <label for="vegan">
              <input type="checkbox" style="float: left;" id="Vegan" name="vegan" value="Vegan">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Vegan</div>
            </label><br>
            <label for="vegatarian">
              <input type="checkbox" style="float: left;" id="Vegatarian" name="vegatarian" value="Vegatarian">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Vegatarian</div>
            </label><br>
            <label for="glutenfree">
              <input type="checkbox" style="float: left;" id="GlutenFree" name="glutenfree" value="GlutenFree">
              <div style="overflow: hidden; padding: 0px 0px 0px 5px;">Gluten Free</div>
            </label><br>
          </form>
        </div>
      </button>
    </div>

    <div class="dropdown">
      <button class="icon-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a19a9a"><path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z"/></svg>
        <div class="dropdown-content">
          <span class="sortby">Sort By
            <svg width="10" height="10" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5.25 2.86875L1.05 7.06875L0 6L6 0L12 6L10.95 7.06875L6.75 2.86875V12L5.25 12L5.25 2.86875Z" fill="#A19A9A"/>
              <path d="M11.25 19.1313L7.05 14.9313L6 16L12 22L18 16L16.95 14.9312L12.75 19.1313L12.75 10H11.25L11.25 19.1313Z" fill="#A19A9A"/>
            </svg>
          </span>
          <span class="option"><a href="#">Recipe Name</a></span>
          <span class="option"><a href="#">Cooking Time</a></span>
          <span class="option"><a href="#">Size<a></span>
        </div>
      </button>
    </div>
  </div>
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

  // Fetch recipes from database
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
                          <span class="category"><?php echo $category; ?> | <?php echo $dietLabelString; ?></span>
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
          echo "<p>No recipes found.</p>";
      }
      $conn->close();
      ?>
  </div>

  <div class="paginationcenter">
    <div class="pagination">
      <a href="#">
        <svg width="24" height="12" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9.65375 19.3075L0 9.65375L9.65375 0L11.073 1.41925L2.83825 9.65375L11.073 17.8883L9.65375 19.3075Z" fill="#A19A9A"/>
          <path d="M21.65375 19.3075L12 9.65375L21.65375 0L23.073 1.41925L14.83825 9.65375L23.073 17.8883L21.65375 19.3075Z" fill="#A19A9A"/>
        </svg>
      </a>
      <a href="#">
        <svg width="12" height="12" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.65375 19.3075L0 9.65375L9.65375 0L11.073 1.41925L2.83825 9.65375L11.073 17.8883L9.65375 19.3075Z" fill="#A19A9A"/>
        </svg>
        </a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">
        <svg width="12" height="12" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1.41925 19.3075L11.073 9.65375L1.41925 0L-1.90735e-06 1.41925L8.23475 9.65375L-1.90735e-06 17.8883L1.41925 19.3075Z" fill="#A19A9A"/>
        </svg>
      </a>
      <a href="#">
        <svg width="24" height="12" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M2.34625 0L12 9.65375L2.34625 19.3075L0.927 17.8883L9.16175 9.65375L0.927 1.41925L2.34625 0Z" fill="#A19A9A"/>
          <path d="M14.34625 0L24 9.65375L14.34625 19.3075L12.927 17.8883L21.16175 9.65375L12.927 1.41925L14.34625 0Z" fill="#A19A9A"/>
        </svg>
      </a>
    </div>
  </div>

  <footer>
    <p>© <script>document.write(new Date().getFullYear())</script> Euan Steven</p>
  </footer>

</body>

</html>