<?php require_once("db.php"); ?>
<?php require_once("scripts_info.php"); ?>

<nav>
    <script type="text/javascript">
        $(document).ready(function (){
                $("input[type=date]").change(function (){
                    var date1 = $("input[name=date1]").val();
                    var date2 = $("input[name=date2]").val();

                    $.get("req/date.php", {
                        calendar_mode: "set",
                        calendar_date1: date1,
                        calendar_date2: date2
                    }, function (){
                        window.location.href = "index.php"
                    });
                });

                $("#buttonCalendar").click(function (){
                    $.get("req/date.php", {
                        calendar_mode: "reset"
                    }, function (){
                        window.location.href = "index.php"
                    });
                });
        });
    </script>

    <div id="navigation">
        <section>
            <div class="navpanel">
                <header><h4>Nawigacja</h4></header>
                <a class="aButton" href="index.php"><div class="button">Strona główna</div></a>
                <a class="aButton" href="game.php"><div class="button">Gra w oczko</div></a>
                <a class="aButton" href="contact.php"><div class="button">Kontakt</div></a>
            </div>
            <div class="navpanel">
                <header><h4>Kalendarz</h4></header>
                <p>Od: <input type="date" name="date1" value="<?php if(isset($_SESSION["date1"])) echo $_SESSION["date1"]; ?>"></p>
                <p>Do: <input type="date" name="date2" value="<?php if(isset($_SESSION["date2"])) echo $_SESSION["date2"]; ?>"></p>
                <button class="button" id="buttonCalendar">Reset</button>
            </div>
        </section>
        <section>
            <div class="navpanel">
                <?php

                    if(isset($_SESSION["user_id"]) && is_numeric($_SESSION["user_id"])) $logged = true;
                    else $logged = false;

                    if($logged)
                    {
                        $user_id = $_SESSION["user_id"];
                        $command_permission = $mysqli->query("SELECT 'true' FROM permission p JOIN role_permission rp ON p.permission_id = rp.permission_id JOIN user u ON rp.role_id = u.role_id WHERE u.user_id = {$user_id} AND p.permission_id = 7");
                        if($command_permission->fetch_assoc())
                        {
                            $canAddPost = true;
                            $_SESSION["post_permission"] = true;
                        }
                        else
                            $canAddPost = false;


                        $command_permission = $mysqli->query("SELECT 'true' FROM permission p JOIN role_permission rp ON p.permission_id = rp.permission_id JOIN user u ON rp.role_id = u.role_id WHERE u.user_id = {$user_id} AND p.permission_id = 8");
                        if($command_permission->fetch_assoc())
                        {
                            $canModifyUsers = true;
                            $_SESSION["modify_users_permission"] = true;
                        }
                        else
                        {
                            $canModifyUsers = false;
                            $_SESSION["modify_users_permission"] = false;
                        }

                        echo ("<h4>Zarządzanie stroną</h4>");
                        if($canModifyUsers) echo ("<a class='aButton' href='users_edit.php'><div class='button'>Zarządzanie użytkownikami</div></a>");
                        if($canAddPost) echo ("<a class='aButton' href='new_article.php'><div class='button'>Dodawanie posta</div></a>");
                        echo("<a class='aButton' href='logout.php'><div class='button'>Wyloguj</div></a>");
                    }
                    else
                    {
                        echo ("<h4>Logowanie</h4>");
                        echo("<form name='login' method='post' action='login.php'>
                            <p><label for='email'>Adres e-mail: </label><input type='email' name='email' id='email' placeholder='Wpisz adres e-mail'></p>
                            <p><label for='password'>Hasło: </label><input type='password' id='password' name='password' placeholder='Wpisz hasło'></p>
                            <a href='register.php'>Zarejestruj się</a>
                            <button type='submit' class='button'>Zaloguj</button>
                            </form>");
                    }
                ?>
            </div>
            <?php
                if($logged)
                {
                    echo("<div class='navpanel'><h4>Konkurs</h4><a class='aButton' href='konkurs.php'><div class='button'>Konkurs</div></a></div>");
                }
            ?>
        </section>
        <section>
            <div class="navpanel">
                <header><h4>Tagi</h4></header>
                <ul>
                    <?php
                        $command_tags = $mysqli->query("SELECT DISTINCT tag FROM article;");
                        $command_tags->data_seek(0);
                        while($row = $command_tags->fetch_assoc())
                        {
                            if($row["tag"] != "")
                                echo("<li><a href='index.php?tag=" . $row["tag"] . "'>" . $row["tag"] . "</a></li>");
                        }
                    ?>
                </ul>
            </div>
        </section>
        <aside>
            <div class="navpanel">
                <header><h4>Polecane linki</h4></header>
                <ul>
                    <li><a href="https://www.w3schools.com/" target="_blank">W3Schools</a></li>
                    <li><a href="https://icons8.com/" target="_blank">icos8</a></li>
                    <li><a href="https://trello.com/" target="_blank">Trello</a></li>
                </ul>
            </div>
        </aside>
    </div>
</nav>
