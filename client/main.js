const recipeContainer = document.querySelector('.recipe');

// Fungsi untuk membuat kartu resep
const createRecipeCard = (recipe) => {
  const card = document.createElement('div');
  card.classList.add('recipe-card');
  card.setAttribute('data-recipe-id', recipe.recipe_id);
  
  // Gunakan function reference, bukan pemanggilan langsung
  card.addEventListener('click', function() {
    openModal(this.getAttribute('data-recipe-id'));
  });
  
  console.log(recipe);

  card.innerHTML = `
    <img src="${recipe.url}" alt="${recipe.recipe_name}" />
    <div class="card-content">
      <div class="card-title">${recipe.recipe_name}</div>
      <div class="card-description">${recipe.description}</div>
    </div>
  `;
  return card;
};

// Fungsi untuk mengambil data dari API
let recipes = [];

const fetchRecipes = async () => {
  try {
    const response = await fetch('http://localhost:8000/server/api.php?aksi=tampil&entity=recipe');
    const textResponse = await response.text();
    const parser = new DOMParser();
    const xml = parser.parseFromString(textResponse, 'application/xml');

    recipes = Array.from(xml.querySelectorAll('recipe')).map((recipeNode) => ({
      recipe_id: recipeNode.querySelector('recipe_id')?.textContent,
      recipe_name: recipeNode.querySelector('recipe_name')?.textContent,
      description: recipeNode.querySelector('description')?.textContent || 'No description available',
      url: recipeNode.querySelector('url')?.textContent || '',
      category: {
        id: recipeNode.querySelector('category_id')?.textContent || 'Unknown',
        name: recipeNode.querySelector('category_name')?.textContent.toLowerCase() || 'uncategorized',
      },
    }));

    renderRecipes();
  } catch (error) {
    console.error('Failed to fetch recipes:', error);
  }
};

// Fungsi untuk merender resep ke layar
const renderRecipes = (filteredRecipes = recipes) => {
  recipeContainer.innerHTML = '';
  filteredRecipes.forEach((recipe) => {
    const card = createRecipeCard(recipe);
    recipeContainer.appendChild(card);
  });
};

console.log(document.getElementById('recipe-search-input')); // Harus tidak null
console.log(document.getElementById('category-dropdown')); // Harus tidak null
// console.log('Filtering with searchInput:', searchInput, 'and selectedCategory:', selectedCategory);

// Fungsi untuk memfilter resep
const filterRecipes = (searchInput, selectedCategory) => {
  recipeContainer.innerHTML = ''; // Hapus resep yang ada

  recipes.forEach((recipe) => {
    const recipeName = recipe.recipe_name.toLowerCase();
    const recipeCategory = recipe.category.name; // Ambil nama kategori dari objek kategori

    if (
      (searchInput === '' || recipeName.includes(searchInput)) &&
      (selectedCategory === '' || recipeCategory === selectedCategory.toLowerCase())
    ) {
      const card = createRecipeCard(recipe);
      recipeContainer.appendChild(card);
    }
  });
};


// Panggil fungsi fetchRecipes saat halaman dimuat
document.addEventListener('DOMContentLoaded', fetchRecipes);

// Tambahkan event listener untuk form pencarian
document.getElementById('recipe-search-form').addEventListener('submit', (event) => {
  event.preventDefault();

  const searchInput = document.getElementById('recipe-search-input').value.toLowerCase();
  const selectedCategory = document.getElementById('category-dropdown').value;

  filterRecipes(searchInput, selectedCategory);
});