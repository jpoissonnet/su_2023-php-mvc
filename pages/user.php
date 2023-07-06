<?php
session_start();

echo $_SESSION["guardLevel"] = $_REQUEST["guardLevel"];