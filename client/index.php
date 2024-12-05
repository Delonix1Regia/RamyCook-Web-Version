<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/headerround-modified.png" type="image/x-icon">
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="modal.css" />
    <title>RamyCook - Find Your Recipe!</title>
  </head>
  <body>
    <nav>
      <div class="nav-logo">
        <div>R</div>
        RamyCook
      </div>
      <button class="login-btn" id="login-btn">Login</button>
    </nav>

    <header class="header-container">
      <div class="header-image">
        <img src="/assets/download-removebg-preview.png" alt="header" />
      </div>
      <div class="header-content">
        <h1>Cook for Your <span>Healthy</span> Life.</h1>
        <p>
          Explore recipes and improve your cooking skills for a healthier life.
        </p>
        <form id="recipe-search-form">
          <div class="form-container">
            <div class="input-row">
              <div class="input-group search-group">
                <span><i class="icon ri-search-line"></i></span>
                <input type="text" id="recipe-search-input" placeholder="Search for Recipe" />
              </div>
              <div class="input-group category-group">
                <span><i class="ri-arrow-down-s-line"></i></span>
                <select class="category-dropdown" id="category-dropdown">
                  <option value="" selected>Categories</option>
                  <option value="Breakfast">Breakfast</option>
                  <option value="Brunch">Brunch</option>
                  <option value="Lunch">Lunch</option>
                  <option value="Dinner">Dinner</option>
                </select>
              </div>
              <button type="submit">Search Recipe</button>
            </div>
          </div>
        </form>
      </div>
    </header>

    <div class="section2-container">
      <h1>Our <span>Menu</span></h1>
    </div>

    <div class="recipe-container">
      <div class="recipe"></div>
    </div>

    <!-- Modal Structure -->
    <div id="recipe-modal">
    <div class="modal-content">
      <span id="close-modal-btn">&times;</span>
      <h2 id="recipe-name"></h2>
      <p id="recipe-category"></p> <!-- For the category -->
      <img id="recipe-image" style="display:none;" />
      <p id="recipe-description"></p>
      <h3>Ingredients</h3>
      <ul id="ingredients-list"></ul>
      <h3>Steps</h3>
      <ol id="steps-list"></ol>
    </div>
  </div>

    <div style="margin-top: 4rem;"></div>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
    <script src="modal.js"></script>
  </body>
</html>
