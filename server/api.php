<?php
error_reporting(1); // Show errors
header('Content-Type: text/xml; charset=UTF-8');

include 'Database.php'; // Include the database class
$db = new Database();   // Create an instance of the database

// Function to filter input data
function filter($data) {
    $data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
    return $data;
}

// Handle request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents("php://input");
    $data = simplexml_load_string($input);
    $aksi = $data->request->aksi;

    // Process action based on the 'aksi' field
    if ($aksi == 'tambah') {
        $entity = $data->request->entity;

        if ($entity == 'recipe') {
            $recipeData = [
                'user_id' => $data->request->recipe->user_id,
                'category_id' => $data->request->recipe->category_id,
                'recipe_name' => $data->request->recipe->recipe_name,
                'description' => $data->request->recipe->description,
                'created_at' => $data->request->recipe->created_at
            ];
            $db->addRecipe($recipeData);
        } elseif ($entity == 'ingredient') {
            $ingredientData = [
                'recipe_id' => $data->request->ingredient->recipe_id,
                'ingredient_name' => $data->request->ingredient->ingredient_name,
                'quantity' => $data->request->ingredient->quantity
            ];
            $db->addIngredient($ingredientData);
        }
    } elseif ($aksi == 'ubah') {
        $entity = $data->request->entity;

        if ($entity == 'recipe') {
            $recipeData = [
                'recipe_id' => $data->request->recipe->recipe_id,
                'user_id' => $data->request->recipe->user_id,
                'category_id' => $data->request->recipe->category_id,
                'recipe_name' => $data->request->recipe->recipe_name,
                'description' => $data->request->recipe->description,
                'created_at' => $data->request->recipe->created_at
            ];
            $db->updateRecipe($recipeData);
        }
    } elseif ($aksi == 'hapus') {
        $entity = $data->request->entity;

        if ($entity == 'recipe') {
            $recipe_id = $data->request->recipe->recipe_id;
            $db->deleteRecipe($recipe_id);
        }
    }
    unset($input, $data, $aksi);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $aksi = $_GET['aksi'] ?? null;
    $entity = $_GET['entity'] ?? null;

    if ($aksi == 'tampil') {
        $id = filter($_GET['id'] ?? '');

        if ($entity == 'recipe' && $id) {
            $data = $db->getRecipeById($id);

            $xml = "<ramycook>";
            $xml .= "<recipe>";
            foreach ($data as $key => $value) {
                if ($key == 'ingredients' || $key == 'steps') {
                    // Convert ingredients and steps array to XML format
                    $xml .= "<$key>";
                    foreach ($value as $item) {
                        $xml .= "<item>" . htmlspecialchars($item) . "</item>";
                    }
                    $xml .= "</$key>";
                } else {
                    $xml .= "<$key>" . htmlspecialchars($value) . "</$key>";
                }
            }
            $xml .= "</recipe>";
            $xml .= "</ramycook>";
            echo $xml;
        } elseif ($entity == 'recipe') {
            $data = $db->getAllRecipes();

            $xml = "<ramycook>";
            foreach ($data as $item) {
                $xml .= "<recipe>";
                foreach ($item as $key => $value) {
                    $xml .= "<$key>" . htmlspecialchars($value) . "</$key>";
                }
                $xml .= "</recipe>";
            }
            $xml .= "</ramycook>";
            echo $xml;
        } elseif ($entity == 'category') {
            $data = $db->getAllCategories();
        
            $xml = "<ramycook>";
            foreach ($data as $item) {
                $xml .= "<category>";
                foreach ($item as $key => $value) {
                    $xml .= "<$key>" . htmlspecialchars($value) . "</$key>";
                }
                $xml .= "</category>";
            }
            $xml .= "</ramycook>";
            echo $xml;
        }
    }
}
?>
