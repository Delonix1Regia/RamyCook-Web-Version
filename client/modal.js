const modal = document.getElementById("recipe-modal");
const closeModalBtn = document.getElementById("close-modal-btn");

function openModal(recipeId) {
  console.log(`Opening modal for recipe ID: ${recipeId}`); // Debugging
  
  // Fetch data from the server based on recipeId using Fetch API
  fetch(`/server/api.php?aksi=tampil&entity=recipe&id=${recipeId}`)
    .then(response => response.text())  // Get the response as text
    .then(data => {
      console.log("Fetched Data:", data); // Debugging response

      const parser = new DOMParser();
      const xml = parser.parseFromString(data, 'application/xml');

      // Log XML to ensure the data is there
      console.log(xml);

      const recipe = xml.querySelector('recipe');
      if (!recipe) {
        console.error("No recipe found in XML.");
        return;
      }

      // Extract recipe data
      const recipeName = recipe.querySelector('recipe_name')?.textContent;
      const description = recipe.querySelector('description')?.textContent;
      const categoryName = recipe.querySelector('category_name')?.textContent || "No Category";  // Fallback for category
      const image = recipe.querySelector('url')?.textContent; // Assuming an <image> tag exists

      // Log recipe data to ensure there are no issues
      console.log(recipeName, description, categoryName, image);

      // Fill the modal with recipe data
      document.getElementById("recipe-name").textContent = recipeName;
      document.getElementById("recipe-description").textContent = description;
      document.getElementById("recipe-category").textContent = categoryName; // Add category

      // Optionally, display an image
      if (image) {
        document.getElementById("recipe-image").src = image;
        document.getElementById("recipe-image").style.display = 'block';
      } else {
        document.getElementById("recipe-image").style.display = 'none'; // Hide image if no URL
      }

      // Fill Ingredients list (if available)
      const ingredientsList = document.getElementById("ingredients-list");
      ingredientsList.innerHTML = ''; // Clear previous list
      const ingredients = recipe.querySelectorAll('ingredients > item');
      const uniqueIngredients = new Set();
      ingredients.forEach(ingredient => {
        const ingredientText = ingredient.textContent.trim();
        if (!uniqueIngredients.has(ingredientText)) {
          uniqueIngredients.add(ingredientText);
          const listItem = document.createElement("li");
          listItem.textContent = ingredientText;
          ingredientsList.appendChild(listItem);
        }
      });

      // Fill Steps list (if available)
      const stepsList = document.getElementById("steps-list");
      stepsList.innerHTML = ''; // Clear previous steps
      const steps = recipe.querySelectorAll('steps > item');
      const uniqueSteps = new Set();
      steps.forEach(step => {
        const stepText = step.textContent.trim();
        if (!uniqueSteps.has(stepText)) {
          uniqueSteps.add(stepText);
          const listItem = document.createElement("li");
          listItem.textContent = stepText;
          stepsList.appendChild(listItem);
        } else {}
      });

      // Show the modal
      modal.style.display = "block";
    })
    .catch(error => console.error("Error fetching recipe data:", error));
}

// Close the Modal
closeModalBtn.onclick = function() {
  modal.style.display = "none";
}

// Close modal if clicked outside the modal
window.onclick = function(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
}
