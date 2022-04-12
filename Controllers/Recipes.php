<?php

namespace Controllers;
require "vendor/autoload.php";
use Core\Controller;

class Recipes extends Controller
{
    # позволит создать поле, где будет храниться
    # модель users

    protected $user;
    protected $recipesModel;
    protected $usersModel;
    public function __construct()
    {
        $this -> $usersModel = new \Models\Users();
        $this -> recipesModel = new \Models\Recipes();
        $this -> user = $this -> $usersModel -> getCurrentUser();
    }

    /**
     * Будет отображать список рецептов
     */
    public function actionIndex(){
        $mainTitle = 'Recipes';
        global $Config;
        $lastRecipes = $this ->recipesModel -> getLastRecipes($Config['RecipesCount']);
        return $this -> render('index', [
            'lastRecipes' => $lastRecipes
        ],
        [
           'MainTitle' => $mainTitle
        ]);
    }

    /**
     * Для просмотра определённого рецепта
     */

    public function actionView(){
        $id = $_GET['id'];
        $recipe = $this -> recipesModel -> getRecipeById($id);

        return $this -> render('view', ['model' => $recipe],
            [
            'MainTitle' => $recipe['title']
        ]);
    }

    /**
     * Проверка, не было ли добавлено постороннего
     * файла вместо картинки
     */

    public function checkPicture($id){
        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];
        if (is_file($_FILES['picture']['tmp_name']) && in_array($_FILES['picture']['type'], $allowedTypes)){
            switch ($_FILES['picture']['type']){

                case 'image/png' :
                    $extension = 'png';
                    break;
                case 'image/jpg' :
                    $extension = 'jpg';
                    break;
                default :
                    $extension = 'jpeg';
            }
            $name = $id.'_'.uniqid().'.'.$extension;
            move_uploaded_file($_FILES['picture']['tmp_name'], 'Files/Images/'.$name);
            $this -> recipesModel -> changePicture($id, $name);
        }
    }

    /**
     * Добавление рецепта
     */

    public function actionAdd(){

        $mainTitle = 'Add recipe';

        if (empty($this -> user)){

            return header( "refresh:0;url=\\users\\login" );
        }

        if ($this -> isPost()){

            $result = $this -> recipesModel -> addRecipes($_POST);
            if ($result['error'] === false){

                $this->checkPicture($result['id']);
                header( "refresh:1;url=\\recipes" );
                return $this -> renderMessage('ok', 'The recipe has been successfully created', null,
                    [
                        'MainTitle' => $mainTitle
                    ]
                );

            }
            else{
                $message = implode('</br>', $result['messages']);
                return $this -> render('form',
                [
                    'model' => $_POST,
                    'PageTitle' => 'Add recipe'
                ],
                [
                   'MainTitle' => $mainTitle,
                   'MessageText' => $message,
                   'MessageClass' => 'danger'
                ]);
            }

        }
        else{
            $params = [
                'MainTitle' => $mainTitle
            ];
            return $this -> render('form', [
                'PageTitle' => 'Add recipe'
            ], $params);
        }

    }



    /**
     * Редактирование рецепта
     */

    public function actionEdit()
    {
        $id = $_GET['id'];
        $recipe = $this->recipesModel->getRecipeById($id);

        if (empty($this->user)) {

            return header("refresh:0;url=\\users\\login");
        }


        if ($this->isPost()) {
            $result = $this->recipesModel->editRecipe($_POST, $id);
            if ($result === true) {
                $this->checkPicture($id);
                header("refresh:2;url=\\recipes\\view?id={$recipe['id']}");
                return $this->renderMessage('ok', 'The recipe has been successfully saved', [
                    'PageTitle' => 'Edit the recipe'
                ],
                    [
                        'MainTitle' => $recipe['title']
                    ]);
            }
            else{
                $message = implode('<br/>', $result);
                return $this -> render('form', ['model' => $recipe],
                [
                    'MainTitle' => $recipe['title'],
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);

            }
        }
        else {

return $this->render('form',
            [
                'model' => $recipe,
                'PageTitle' => 'Edit the recipe'
            ],
            [
                'MainTitle' => 'Edit the recipe'
            ]);
        }
    }

    /**
     * Удаление рецепта
     */

    public function actionDelete(){

        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes'){
            if($this -> recipesModel -> deleteRecipe($id)){
                header('Location:\\recipes\\');
            }
            else{
                $recipe = $this -> recipesModel -> getRecipeById($id);
                return $this -> render('delete', ['model' => $recipe],
                    [
                        'MainTitle' => 'Deletion of the recipe',
                        'MessageText' => 'Error',
                        'MessageClass' => 'danger'
                    ]);
            }
        }
        $recipe = $this -> recipesModel -> getRecipeById($id);
        return $this -> render('delete', [
            'model' => $recipe
        ], [
            'MainTitle' => 'Deletion of the recipe'
        ]);
    }

    public function actionFilterByCategory(){
        if (isset($_GET['category'])){
            $category = $_GET['category'];
            if($this -> recipesModel -> getRecipesByCategory($category)){
                $recipes = $this -> recipesModel -> getRecipesByCategory($category);
                return $this -> render('index', [
                    'lastRecipes' => $recipes
        ], [
                    'MainTitle' => 'All recipes'
                ]);
            }
            else {
                $mainTitle = 'Рецепти';
                global $Config;
                $lastRecipes = $this->recipesModel->getLastRecipes($Config['RecipesCount']);
                return $this->render('index', [
                    'lastRecipes' => $lastRecipes
                ],
                    [
                        'MainTitle' => $mainTitle
                    ]);
            }
        }
//        $recipe = $this -> recipesModel -> getRecipeById($id);

    }

    public function actionFilterByUser(){
        if (isset($_GET['user_id'])){
            $id = $_GET['user_id'];
            if($this -> recipesModel -> getRecipesByUserId($id)){
                $recipes = $this -> recipesModel -> getRecipesByUserId($id);
                return $this -> render('index', [
                    'lastRecipes' => $recipes
                ], [
                    'MainTitle' => 'Recipes of the users'
                ]);
            }
            else {
                $mainTitle = 'Recipes';
                global $Config;
                $lastRecipes = $this->recipesModel->getLastRecipes($Config['RecipesCount']);
                return $this->render('index', [
                    'lastRecipes' => $lastRecipes
                ],
                    [
                        'MainTitle' => $mainTitle
                    ]);
            }
        }
//        $recipe = $this -> recipesModel -> getRecipeById($id);

    }

    public function actionSort(){
        if (isset($_GET['sort'])){
            $sort = $_GET['sort'];
            if($this -> recipesModel -> getSortedRecipes($sort)){
                $recipes = $this -> recipesModel -> getSortedRecipes($sort);
                var_dump($recipes);
                return $this -> render('index', [
                    'lastRecipes' => $recipes
                ], [
                    'MainTitle' => 'All recipes'
                ]);
            }
            else {
                $mainTitle = 'Recipes';
                global $Config;
                $lastRecipes = $this->recipesModel->getLastRecipes($Config['RecipesCount']);
                var_dump($lastRecipes);
                return $this->render('index', [
                    'lastRecipes' => $lastRecipes
                ],
                    [
                        'MainTitle' => $mainTitle
                    ]);
            }
        }
//        $recipe = $this -> recipesModel -> getRecipeById($id);

    }



}