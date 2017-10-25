<?php
ob_start();
function Query($filter){
    $manager = new MongoDB\Driver\Manager("mongodb://mongodb:27017");  
    // 查询数据
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery('ctf.users', $query);
    $result = array();
    foreach ($cursor as $document) {
        $result[$document->name] = $document->passwd;
    }
    return $result;
}

if (isset($_REQUEST['username']) && isset($_REQUEST['passwd'])) {
    $name = $_REQUEST['username'];
    $pass = $_REQUEST['passwd'];
}else{
    die("Please Input username and passwd");
}

$filter = ['name' => $name, 'passwd' => $pass];

$data = Query($filter);
if ($data == array() && $name === 'admin') {
    Header("Location: http://123.206.98.106:8080/index.php?message=Passwd Error!"); 
}else if ($data == array() && $name !== 'admin') {
    Header("Location: http://123.206.98.106:8080/index.php?message=User does not exists!"); 
}else{
    foreach ($data as $key => $value) {
        echo $key;
        echo "<br>";
        echo $value;
    }
    if ($pass === 'dajkfsga1234!@#$c.!') {
        Header("Location: http://123.206.98.106:8080/index.php?message=flag{G00d_J0b!@#$}");
    }
}

?>