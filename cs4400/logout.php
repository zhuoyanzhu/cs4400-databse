<?php
    session_start();
    session_destroy();

    include "utils.php";

    Redirect("./index.php");
?>