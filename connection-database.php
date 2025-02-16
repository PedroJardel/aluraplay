<?php

$dbPath = __DIR__ . "/database.sqlite";
$connection = new PDO("sqlite:$dbPath");

$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

return $connection;

/* seed script
* $connection->exec("CREATE TABLE videos (id INTEGER PRIMARY KEY, url TEXT, title TEXT);");
*/

