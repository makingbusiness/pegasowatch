<?php 
    $lista = explode(',',$resultado);
    for($i=0;$i < count($lista); $i+=3)
         printf("%25s%10s%10s<br>",$lista[$i],$lista[$i+1],$lista[$i+2]);
?>