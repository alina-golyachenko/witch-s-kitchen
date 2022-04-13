<link rel="stylesheet" href="..\Styles\recipes.css">
<link rel="shortcut icon" href="Files\Icons\title_Icon.ico" />

<div class="mainSection">
    <div class="diva1">

        <a href="" class="sectionName" id="sort" style="text-decoration: none">Sort by</a>

        <div class="buttonSection">
            <div class="buttons">
                <input class="btna btna1 input" type="button" value="Newer first">
                <input class="btna btna2 input" type="button" value="Older first">
                <script>
                    let link = document.getElementById('sort');
                    let buttons = document.getElementsByClassName('btna');
                    for (let button of buttons) {
                        button.addEventListener('click', () => {
                            link.innerHTML = button.value;
                            window.location.href = "\\recipes\\sort?sort=" + button.value;
//                             link.href = '\\recipes\\sort?sort=' + button.value;
                        });
                    }
                    link.style.textDecoration = "none";
                </script>
                <link rel="shortcut icon" href="Files\Icons\title_Icon.ico" />


            </div>
            <div class="emptySection"></div>
        </div>
    </div>
</div></br>
<a class="regularSection" href="\recipes\add">Add recipe</a>



<?php
$recipeIndex = 1;
$stringIndex = '';

$userModel = new \Models\Users();
$user = $userModel -> getCurrentUser();


$recipesModel = new \Models\Recipes();


# если пользователь не аутентифицирован,
# рецепт он добавить не сможет
foreach ($lastRecipes as $recipe) : ?>
    <div class="card-container">
        <div class="card u-clearfix">
            <div class="card-body">
                <?php
                if($recipeIndex < 10) {
                     $stringIndex = '0'."{$recipeIndex}";
                }
                else{
                    $stringIndex = $recipeIndex;
                }
                $recipeIndex++;
                ?>
                <span class="card-number card-circle"><?= $stringIndex?></span>
                <span class="card-author">@<?=$userModel -> getUserById($recipe['user_id'])['username'] ?></span>
                <h2 class="card-title"><?=$recipe['title']?></h2>
                <span class="card-description"><?=$recipe['shortDescription'] ?></span>
                <a class="regularSection" href="\recipes\view?id=<?=$recipe['id'] ?>" class="card-read regularSection">View</a>
                <a class="card-tag card-circle subtle" href="\recipes\filterByCategory?category=<?=$recipe['category'] ?>"><span class="inside-circle"><?=$recipe['category'] ?></span></a>
            </div>
            <div class="card-media">
                <? if (is_file('Files/Images/'.$recipe['picture'])) : ?>
                    <img src="/Files/Images/<?=$recipe['picture']?>">
                <? endif; ?>
            </div>
        </div>
        <div class="card-shadow"></div>
    </div>
<?php endforeach;
$recipeIndex = 1; ?>