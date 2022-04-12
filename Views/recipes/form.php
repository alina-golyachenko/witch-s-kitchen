<div id="addingContainer">
    <link rel="stylesheet" href="..\Styles\add.css">
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <script type="text/javascript" src="..\froala_editor_4.0.8\js\froala_editor.min.js"></script>    <div class="main">
        <link rel="stylesheet" href="..\froala_editor_4.0.8\css\froala_editor.css">
        <link rel="stylesheet" href="..\froala_editor_4.0.8\css\froala_style.css">
        <input type="checkbox" id="chk" aria-hidden="true">
        <form class="register" method="post" action="" enctype="multipart/form-data">
            <!--             enctype="multipart/form-data" означает,-->
            <!--             что теперь форма может отправлять данные на сервер-->
            <label for="chk" aria-hidden="true"><?=$PageTitle ?></label>
            <input id="title" class="regularSection input" type="text" name="title" placeholder="name" value="<?= $model['title'] ?>">

            <textarea id="ingredients" class="textblock regularSection" type="text" name="ingredients" placeholder="ingredients and their names. Enter every ingredient from a new line"><?= $model['ingredients'] ?></textarea>
            <textarea id="description" class="regularSection textblock" type="text" name="description" placeholder="cooking directions"><?= $model['description'] ?></textarea>

            <textarea id="shortDescription" class="textblock regularSection" type="text" name="shortDescription" placeholder="short description of the recipe"><?= $model['shortDescription'] ?></textarea>

            <label style="font-size: 20px" for="chk" aria-hidden="true">Add picture:</label>
            <input type="file" accept="image/jpg, image/png, image/jpeg" class="picture" name="picture" id="picture">

            <div class="mainSection">
                <div class="diva1">
                    <textarea class="sectionName" id="category" name ='category'><?= $model['category'] ?? 'Cathegory' ?></textarea>

                    <div class="buttonSection">
                        <div class="buttons">
                            <input class="btna btna1 input" type="button" value="First course">
                            <input class="btna btna2 input" type="button" value="Main course">
                            <input class="btna btna3 input" type="button" value="Appetizers">
                            <input class="btna btna4 input" type="button" value="Baked goods">
                            <input class="btna btna5 input" type="button" value="Desserts">
                            <input class="btna btna6 input" type="button" value="Drinks">
                            <input class="btna btna7 input" type="button" value="Other">
                            <script>
                                let textarea = document.getElementById('category');
                                let buttons = document.getElementsByClassName('btna');
                                for (let button of buttons) {
                                    button.addEventListener('click', () => {
                                        textarea.innerHTML = button.value;
                                    });
                                }
                            </script>
                        </div>
                        <div class="emptySection"></div>
                    </div>
                </div>
            </div>
            <button type="submit">Зберегти</button>
        </form>

    </div>
    <ul class="clouds">
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
        <li><img src="\Files\Images\cloud.png"></li>
    </ul>
</div>





