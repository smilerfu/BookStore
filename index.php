<?php
    //phpinfo();
    $table = 'aaa';
    $a = array('ab'=>1, 'cd'=>2);
   // echo array_keys($a);
    //echo join(",", array_keys($a));
    $keys=join(",", array_keys($a));
    $values="'".join("','", array_values($a))."'";
    
   // echo $values;
    
    $sql="insert into {$table}($keys) values($values)";
    echo $sql;
?>