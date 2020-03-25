<?php
// http://localhost/query.php/105
//come ottenere il parametro da path
$pathArray = explode('/', $_SERVER['REQUEST_URI']);

echo 'path: '.$pathArray[1]; //<- "query.php"
echo '<br>';
echo 'param: '.$pathArray[2]; // <---- qui c'è il parametro 105
?>
