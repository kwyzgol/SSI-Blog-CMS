<?php
    session_start();

    if(isset($_GET["calendar_mode"]))
    {
        if($_GET["calendar_mode"] == "set")
        {
            if(isset($_GET["calendar_date1"]) && $_GET["calendar_date1"] != "")
            {
                $_SESSION["date1"] = $_GET["calendar_date1"];
                $_SESSION["date1_command"] = "{$_SESSION["date1"]} 00:00:00";
            }

            if(isset($_GET["calendar_date2"]) && $_GET["calendar_date2"] != "")
            {
                $_SESSION["date2"] = $_GET["calendar_date2"];
                $_SESSION["date2_command"] = "{$_SESSION["date2"]} 23:59:59";;
            }
        }

        if($_GET["calendar_mode"] == "reset")
        {
            unset($_SESSION["date1"]);
            unset($_SESSION["date1_command"]);
            unset($_SESSION["date2"]);
            unset($_SESSION["date2_command"]);
        }
    }
?>