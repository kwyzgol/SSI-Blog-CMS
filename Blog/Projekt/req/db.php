<?php
    session_start();

    $mysqli = new mysqli("localhost", "root", "", "blog");
    $mysqli->autocommit(false);

    function transaction($mysqli, $array)
    {
        $mysqli->begin_transaction();

        try
        {
            foreach ($array as $command)
            {
                $mysqli->query($command);
            }
            $mysqli->commit();
            return true;
        }
        catch (mysqli_sql_exception $exception)
        {
            $mysqli->rollback();
            return false;
        }
    }
    ?>