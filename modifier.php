<?php
#20960
$entradas = fopen("entradaschile.csv","r");
$produccion = fopen("prod-chile.csv","r");
$fp = fopen("new-file.csv", 'a');
echo "<pre>";
$count = 1;
while(! feof($entradas)){
	$nuevo = "";
	$data = fgetcsv($entradas, 50000000, ",");
	if(is_array($data)){
		if($count > 1){
			if(isset($data[40] ) && $data[40] != ""){
				while(! feof($produccion) && $count < 100){
					$dataprod = fgetcsv($produccion, 50000000, ",");
					if(isset($dataprod) && $dataprod !=null){
						if((isset($dataprod[0]) && $dataprod[0] !=null) && (isset($dataprod[1]) && $dataprod[1] !=null)){
							$nuevo = findInStaging($dataprod[1]);
						}
					}
				}
				$data[40] = $nuevo;
			}

		}
		$count++;
		fputcsv($fp, $data);
	}
}
fclose($entradas);
fclose($fp);

echo "Proceso Finalizado!!";


function findInStaging($name){

$res = $name."NOT FOUND";
$staging = fopen("stagingempresas.csv","r");
$encontrado = false;
	while(! feof($staging) && !$encontrado){
		$data = fgetcsv($staging, 50000000, ",");
		if((isset($data[0]) && $data[0] !=null) && (isset($data[1]) && $data[1] !=null)){
			if(trim($data[1]) == trim($name)){
				$res = $data[0];
				$encontrado = true;
			}
		}
	}
fclose($staging);
return $res;

}





