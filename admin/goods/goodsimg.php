<?php
include_once '../../common.php';

$sql = "select * from shop_goods";
$re = sql_query($sql);
for($i=0;$ro=sql_fetch_array($re);$i++){
    $fo = $ro['simg1'];
   if(strpos($fo,'/')){ 
        $foa = explode("/",$fo);
            $path = "../../data/goods/".$foa[0]."/";

            if(is_dir($path)) {
                if($dh = opendir($path)) {
                    $i=0;
                    while(($file = readdir($dh)) !== false) {
                        $i=$i+1;
                        if ($file == "." || $file == "..") {
                            continue;
                        }
                        $fname = $path.$file;
                        $fname2 = $path.$foa[1];
                        if($i==1){
                            if(is_file($fname2)) {
                                echo $fo;
                                echo "<br/>";  
                                echo "filename: ".$file."<br>";
                                 //if(strpos($fname,'(1)') && strpos($fname2,'(1)')){ 
                                 //    copy($fname, $fname2); 
                                 //}
                                 
                            }
                        }
                       
                    }
                    closedir($dh);
                }
            }

   }    
}