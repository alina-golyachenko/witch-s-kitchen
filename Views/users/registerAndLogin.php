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

<div id="addingContainer" style="margin-bottom: 120px">
        <link rel="stylesheet" href="..\Styles\registrationForm.css">
    <link rel="shortcut icon" href="Files\Icons\title_Icon.ico" />

    <script async src="..\JS\registrationForm.js"></script>
        <link rel="stylesheet" type="text/css" href="slide navbar style.css">

        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="register">
                <form enctype="multipart/form-data" method="post" action="\users\register">
                    <label class="mainLabel" for="chk" aria-hidden="true">Sign in</label>
                    <input id="username" type="text" name="username" value="<?=$_POST['username'] ?>" placeholder="nickname" required="">
                    <input id="email" type="email" name="email" placeholder="email" required="" value="<?=$_POST['email'] ?>">
                    <input id="password" type="password" name="password" placeholder="password" required="">
                    <input type="password" name="repeatPassword" placeholder="repeat password" required="">

                    <input type="file" accept="image/jpg, image/png, image/jpeg" class="picture" name="picture" id="picture">


                    <button type="submit">Let's go</button>
                </form>
            </div>

            <div class="login">
                <form method="post" action="\users\login">
                    <label class="mainLabel" for="chk" aria-hidden="true">Login</label>
                    <input name="email" placeholder="email" required="">
                    <input type="password" name="password" placeholder="password" required="">
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
</div>

