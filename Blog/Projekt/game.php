<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kamil Wyżgoł - blog</title>
    <?php require_once("req/scripts_info.php"); ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">
    <?php require_once("req/header.php"); ?>
    <?php require_once("req/navigation.php"); ?>
    <div id="content">
        <section>
        <?php
            $end = false;

            class Card
            {
                public $name;
                public $value;

                function __construct($name, $value)
                {
                    $this->name=$name;
                    $this->value=$value;
                }
            }

            //Klasa zarządzająca całą grą
            class Game
            {
                public $deck;
                public $score;
                public $history;

                public $player;
                public $computer;

                public $firstRound;
                public $winner;

                function __construct()
                {
                    $this->firstRound=true;

                    $this->deck=array();
                    $this->score=array();
                    $this->history=array();

                    $typeArray=array('pik', 'kier', 'karo', 'trefl');

                    $index = 0;

                    foreach ($typeArray as $type)
                    {
                        for ($i = 2; $i <= 14; $i++)
                        {
                            if($i <= 10)
                            {
                                $name = "{$i} {$type}";
                                $value = $i;
                            }
                            else
                            {
                                if($i == 11)
                                {
                                    $name = "Walet {$type}";
                                    $value = 2;
                                }
                                if($i == 12)
                                {
                                    $name = "Dama {$type}";
                                    $value = 3;
                                }
                                if($i == 13)
                                {
                                    $name = "Król {$type}";
                                    $value = 4;
                                }
                                if($i == 14)
                                {
                                    $name = "As {$type}";
                                    $value = 11;
                                }
                            }

                            $this->deck[$index++] = new Card($name, $value);
                        }
                    }

                    shuffle($this->deck);

                    $this->score["player"]=0;
                    $this->score["computer"]=0;

                    $this->player=true;
                    $this->computer=true;
                }

                public function AddHistory($player, $cardName, $value)
                {
                    if($player == "player")
                        array_unshift($this->history, "<p class='gameTextPlayer'>Dobrałeś kartę <b>{$cardName}</b> o wartości <b>{$value}</b>.</p>");
                    else
                    {
                        array_unshift($this->history, "<p class='gameTextComputer'>Krupier dobrał kartę <b>{$cardName}</b> o wartości <b>{$value}</b>.</p>");
                        $this->firstRound=false;
                    }
                }

                public function Draw($player)
                {
                    $tmpIndex = rand(0, count($this->deck)-1);
                    $card = $this->deck[$tmpIndex];
                    $tmpValue = $card->value;
                    $tmpName = $card->name;
                    $this->score[$player] += $tmpValue;
                    array_splice($this->deck, $tmpIndex, 1);

                    if($player == "player" || $this->firstRound)
                    {
                        $this->AddHistory($player, $tmpName, $tmpValue);
                    }
                }

                public function Stop($player)
                {
                    $this->$player=false;
                }

                public function Check($player)
                {
                    if($this->$player)
                    {
                        if($this->score[$player] == 21)
                            $this->winner=$player;
                        if($this->score[$player] > 21)
                        {
                            if ($player == "player") $this->winner = "computer";
                            if ($player == "computer") $this->winner = "player";
                        }
                    }

                    if($this->player == false && $this->computer == false)
                    {
                        if($this->score["player"] > $this->score["computer"]) $this->winner="player";
                        if($this->score["player"] < $this->score["computer"]) $this->winner="computer";
                        if($this->score["player"] == $this->score["computer"]) $this->winner="none";
                    }
                }
            }

            //Wyświetlanie strony (gra)
            function SitePlay()
            {
                echo("
                        <article>
                            <div class='article'>
                                <h3>Gra w oczko</h3>
                                <p>Aktualna ilość punktów: <b>{$_SESSION["game"]->score["player"]}</b></p>
                                <a href='game.php?mode=play'><button class='button comment'>Dobierz</button></a>
                                <a href='game.php?mode=stop'><button class='button comment'>Spasuj</button></a>
                            </div>
                        </article>
                        <article>
                            <div class='article'>
                                <h3>Dobrane karty</h3>
                                <ul>");
                foreach($_SESSION["game"]->history as $historyRecord)
                {
                    echo("<li>{$historyRecord}</li>");
                }

                echo("          </ul>
                            </div>
                        </article>
                        ");
            }

            //Wyświetlanie strony (wynik)
            function SiteResult()
            {
                echo("
                        <article>
                            <div class='article'>
                                <h3>Wynik</h3>");
                if($_SESSION["game"]->winner == "computer")echo ("<p>Wygrał <b><span class='gameTextComputer'>Krupier</span></b></p>");
                if($_SESSION["game"]->winner == "player")echo ("<p>Wygrał <b><span class='gameTextPlayer'>Gracz</span></b></p>");
                if($_SESSION["game"]->winner == "none")echo ("<p>Wynik: <b>remis</b></p>");
                echo("          <p class='gameTextPlayer'>Punkty gracza: {$_SESSION["game"]->score["player"]}</p>
                                <p class='gameTextComputer'>Punkty krupiera: {$_SESSION["game"]->score["computer"]}</p>
                                <a href='game.php?'><button class='button comment'>Zagraj jeszcze raz</button></a>
                            </div>
                        </article>
                        ");
                echo (" <article>
                            <div class='article'>
                                <h3>Dobrane karty</h3>
                                <ul>");
                foreach($_SESSION["game"]->history as $historyRecord)
                {
                    echo("<li>{$historyRecord}</li>");
                }
                echo("          </ul>
                            </div>
                        </article>
                        ");

                //usuwanie sesji
                unset($_SESSION["game"]);
            }

            //Dobieranie kart (+ dobieranie 2 kart na początku)
            if(isset($_GET["mode"]) && $_GET["mode"]=="play")
            {
                if(isset($_SESSION["game"]) == false) $_SESSION["game"] = new Game();
                if($_SESSION["game"]->firstRound)
                {
                    $_SESSION["game"]->Draw("player");
                    $_SESSION["game"]->Draw("player");
                    $_SESSION["game"]->Check("player");

                    if(empty($_SESSION["game"]->winner))
                    {
                        $_SESSION["game"]->Draw("computer");
                        $_SESSION["game"]->Draw("computer");
                        $_SESSION["game"]->Check("computer");
                        if($_SESSION["game"]->score["computer"] >= 16)
                            $_SESSION["game"]->Stop("computer");
                    }

                    if(empty($_SESSION["game"]->winner) == false)
                    {
                        SiteResult();
                        $end = true;
                    }
                }

                if($end == false)
                {
                    $_SESSION["game"]->Draw("player");
                    $_SESSION["game"]->Check("player");
                    if(empty($_SESSION["game"]->winner))
                    {
                        if($_SESSION["game"]->score["computer"] >= 16)
                            $_SESSION["game"]->Stop("computer");
                        else
                        {
                            $_SESSION["game"]->Draw("computer");
                            $_SESSION["game"]->Check("computer");

                            if($_SESSION["game"]->score["computer"] >= 16)
                                $_SESSION["game"]->Stop("computer");
                        }

                        if(empty($_SESSION["game"]->winner) == false)
                        {
                            SiteResult();
                            $end = true;
                        }
                        else SitePlay();
                    }
                    else
                    {
                            SiteResult();
                            $end = true;
                    }
                }
            }

            //Spasowanie
            if(isset($_GET["mode"]) && $_GET["mode"]=="stop")
            {
                //gra stop
                $_SESSION["game"]->Stop("player");
                $_SESSION["game"]->Check("player");

                if($_SESSION["game"]->computer != false)
                {
                    while($_SESSION["game"]->score["computer"] < 16)
                    {
                        $_SESSION["game"]->Draw("computer");
                        $_SESSION["game"]->Check("computer");

                        if($_SESSION["game"]->score["computer"] >= 16)
                            $_SESSION["game"]->Stop("computer");
                    }
                    if(empty($_SESSION["game"]->winner)) $_SESSION["game"]->computer == false;
                }
                if(empty($_SESSION["game"]->winner)) $_SESSION["game"]->Check("computer");

                SiteResult();
            }

            //Strona startowa (informacje)
            if(isset($_GET["mode"]) == false)
            {
                //start
                echo("
                        <article>
                            <div class='article'>
                                <h3>Gra w oczko</h3>
                                <h4>Informacje</h4>
                                <ul>
                                    <li>Talia składa się z 52 kart.</li>
                                    <li>Zarówno gracz jak i komputerowy krupier na początku dobierają 3 karty (2 karty startowe + jedna związana z rozpoczęciem gry).</li>
                                    <li>Krupier zawsze pasuje przy 16 lub więcej punktach.</li>
                                    <li>Gracz ma możliwość spasowania, o ile nie przekroczył wartości 21, która oznacza przegraną.</li>
                                    <li>Gracz ma możliwość zobaczenia dobieranych przez siebie kart oraz pierwszej karty dobranej przez krupiera.</li>
                                    <li>Pierwszy ruch należy do gracza.</li>
                                </ul>
                                <br>
                                <h4>Wartości kart</h4>
                                <ul>
                                    <li>Karty od 2 do 10 - zgodnie z oznaczeniem</li>
                                    <li>Walet - 2 pkt.</li>
                                    <li>Dama - 3 pkt.</li>
                                    <li>Król - 4 pkt.</li>
                                    <li>As - 11 pkt.</li>
                                </ul>
                                <a href='game.php?mode=play'><button class='button comment'>Zagraj</button></a>
                            </div>
                        </article>
                        ");
            }
        ?>
        </section>
    </div>
    <?php require_once("req/footer.php"); ?>
</div>

<?php require_once("req/scripts.php") ?>

</body>
</html>
