<?php
class Database {
    private $host = "localhost";
    private $dbname = "ramycook";
    private $user = "root";
    private $password = "";
    private $port = "3306";
    private $conn;

    public function __construct() {
        // Koneksi database menggunakan PDO
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname . ";charset=utf8", $this->user, $this->password);
        } catch (PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }

    // CRUD untuk tabel `recipes`
    public function getAllRecipes($category_name = null) {
        $sql = "SELECT recipes.*, categories.category_name FROM recipes 
                JOIN categories ON recipes.category_id = categories.category_id";
        
        if ($category_name) {
            $sql .= " WHERE categories.category_name = :category_name";
        }
    
        $sql .= " ORDER BY recipe_id";
        $query = $this->conn->prepare($sql);
        
        if ($category_name) {
            $query->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        }
        
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }    

    public function getRecipeById($recipe_id) {
        // Query to get recipe data, category, ingredients, and steps
        $query = $this->conn->prepare("
            SELECT r.recipe_id, r.recipe_name, r.description, r.url, c.category_name, 
                   GROUP_CONCAT(i.ingredient_name, ': ', i.quantity ORDER BY i.ingredient_name) AS ingredients,
                   GROUP_CONCAT(s.step_description ORDER BY s.steps_id) AS steps
            FROM recipes r
            LEFT JOIN categories c ON r.category_id = c.category_id
            LEFT JOIN ingredients i ON r.recipe_id = i.recipe_id
            LEFT JOIN steps s ON r.recipe_id = s.recipe_id
            WHERE r.recipe_id = ?
            GROUP BY r.recipe_id
        ");
        
        // Execute the query with the recipe_id parameter
        $query->execute([$recipe_id]);
        
        // Fetch the result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        
        // If data is found, process ingredients and steps into arrays
        if ($data) {
            $data['ingredients'] = explode(',', $data['ingredients']);  // Split ingredients into an array
            $data['steps'] = explode(',', $data['steps']);  // Split steps into an array
        }
        
        return $data;
    }       

    public function addRecipe($data) {
        $query = $this->conn->prepare("INSERT INTO recipes (user_id, category_id, recipe_name, description, created_at) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$data['user_id'], $data['category_id'], $data['recipe_name'], $data['description'], $data['created_at']]);
        $query->closeCursor();
    }

    public function updateRecipe($data) {
        $query = $this->conn->prepare("UPDATE recipes SET user_id = ?, category_id = ?, recipe_name = ?, description = ?, created_at = ? WHERE recipe_id = ?");
        $query->execute([$data['user_id'], $data['category_id'], $data['recipe_name'], $data['description'], $data['created_at'], $data['recipe_id']]);
        $query->closeCursor();
    }

    public function deleteRecipe($recipe_id) {
        $query = $this->conn->prepare("DELETE FROM recipes WHERE recipe_id = ?");
        $query->execute([$recipe_id]);
        $query->closeCursor();
    }

    // CRUD untuk tabel `categories`
    public function getAllCategories() {
        $query = $this->conn->prepare("SELECT * FROM categories ORDER BY category_id");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }

    // CRUD untuk tabel `ingredients`
    public function getIngredientsByRecipeId($recipe_id) {
        $query = $this->conn->prepare("SELECT * FROM ingredients WHERE recipe_id = ?");
        $query->execute([$recipe_id]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }

    public function addIngredient($data) {
        $query = $this->conn->prepare("INSERT INTO ingredients (recipe_id, ingredient_name, quantity) VALUES (?, ?, ?)");
        $query->execute([$data['recipe_id'], $data['ingredient_name'], $data['quantity']]);
        $query->closeCursor();
    }

    public function deleteIngredient($ingredient_id) {
        $query = $this->conn->prepare("DELETE FROM ingredients WHERE ingredient_id = ?");
        $query->execute([$ingredient_id]);
        $query->closeCursor();
    }

    // CRUD untuk tabel `steps`
    public function getStepsByRecipeId($recipe_id) {
        $query = $this->conn->prepare("SELECT * FROM steps WHERE recipe_id = ?");
        $query->execute([$recipe_id]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }

    public function addStep($data) {
        $query = $this->conn->prepare("INSERT INTO steps (recipe_id, step_description) VALUES (?, ?)");
        $query->execute([$data['recipe_id'], $data['step_description']]);
        $query->closeCursor();
    }

    public function deleteStep($steps_id) {
        $query = $this->conn->prepare("DELETE FROM steps WHERE steps_id = ?");
        $query->execute([$steps_id]);
        $query->closeCursor();
    }

    // CRUD untuk tabel `users`
    public function getUserById($user_id) {
        $query = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $query->execute([$user_id]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }
}
?>
