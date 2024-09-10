<!doctype html>
<html lang="en">
<!-- Design by Euan Steven -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Recipes">
  <meta name="author" content="Euan Steven">

  <title>Recipe Manager | Import</title>

  <meta property="og:title" content="Recipe Manager | Import">
  <meta property="og:type" content="website">
  <meta property="og:image" content="/assets/images/covers/import_cover.jpg">
  <meta property="og:description" content="Import">
  <meta property="og:locale" content="en_GB">

  <link rel="icon" href="/assets/icons/favicon.ico sizes="any">
  <link rel="icon" href="/assets/icons/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/assets/icons/icon.png">

  <link rel="stylesheet" href="/assets/css/main.css">

  <script src="/assets/js/main.js"></script>
</head>

<body>

  <div class="intro">
    <h1>Recipe Manager</h1>
    <h2>// Import</h2>
    <div class="back-button">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#A19a9a">
        <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/>
      </svg>
      <span><a class="back" href="/manager.html">Back</a></span>
    </div>
  </div>

  <div class="import-boxes">
    <div class="import-box">
        <h3>Website</h3>
        <p>Enter one or more URLs, each on a new line</p>
        <textarea></textarea>
        <button class="add-button">Submit</button>
    </div>
    
    <div class="import-box">
        <h3>File</h3>
        <p>Choose files in .txt or .json format</p>
        <div class="file-input">
          <form action="/scan_import.php">
            <input type="file" id="myfile" name="myfile"><br><br>
            <input type="submit">
          </form>
        </div>
    </div>
</div>

  <footer>
    <p>© <script>document.write(new Date().getFullYear())</script> Euan Steven</p>
  </footer>

</body>

</html>