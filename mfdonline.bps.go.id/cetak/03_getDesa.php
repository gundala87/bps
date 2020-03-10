<!DOCTYPE html>
<html>
<head>
	<title>BPS - Get Desa</title>
	<meta http-equiv="refresh" content="30" />
</head>
<body>
<!--
https://mfdonline.bps.go.id/master/cetak/cetak_prov.php
https://mfdonline.bps.go.id/master/cetak/cetak_kab.php?idprov=12
https://mfdonline.bps.go.id/master/cetak/cetak_kec.php?idprov=12&idkab=09
https://mfdonline.bps.go.id/master/cetak/cetak_desa.php?idprov=12&idkab=09&idkec=120
-->
<?php
include_once('simple_html_dom.php');
include("conn.php");
$d = "SELECT kodePro,namaPro,kodeKab,namaKab,kodeKec,namaKec 
		FROM cetak_kec
		ORDER BY kodePro ASC, kodeKab ASC,kodeKec ASC";
		//WHERE namaPro='DKI JAKARTA'
$sqlD = mysqli_query($conn,$d);
$countD = mysqli_num_rows($sqlD);
//var_dump($d);exit;
//var_dump($countD);exit;

$nod = 1;
while($r=mysqli_fetch_array($sqlD)){
	$kodeKecD = $r['kodeKec'];
	$namaKecD = $r['namaKec'];
	
	$kodeKabD = $r['kodeKab'];
	$namaKabD = $r['namaKab'];
	
	$kodeProD = $r['kodePro'];
	$namaProD = $r['namaPro'];
	
	//$url 	= 'https://mfdonline.bps.go.id/master/cetak/cetak_desa.php?idprov=12&idkab=09&idkec=120';
	$url 	= 'https://mfdonline.bps.go.id/master/cetak/cetak_desa.php?idprov='.$kodeProD.'&idkab='.$kodeKabD.'&idkec='.$kodeKecD;
	//var_dump($url);exit;
	echo "Data Ke-".$nod."<br>";

				
	$dirf			= "File Master/Kec/".$kodeProD."/".$kodeKabD;
	//var_dump($dirf);exit;
	if (!is_dir($dirf)) {
		mkdir($dirf, 0777, true);
	}
	//exit;
	$filename 	= $dirf.'/'.$kodeKecD.".html";
	//var_dump($filename);exit;
	$size = getFileSize($filename);
	//var_dump(formatSizeUnits($size));exit;
	if ($size <= 40){
		if (file_exists($filename)) {
			$a = unlink($filename);
			if($a){
				echo "=> The file $filename,with size $size delete<br>";//exit;
			}else{
				echo "=> The file $filename,with size $size can't delete<br>";//exit;	
			}						
		} else {
			echo "=> The file $filename don't exists<br>";//exit;		
		}
	}else {
		echo "=> The file $filename with size $size ready.<br>";//exit;	
	}

	if (!file_exists($filename)) {
		$ch 	= curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result	= curl_exec($ch);
		//curl_close($ch);
		//$dt 	= json_decode($result, true);
		//var_dump($result);exit;
		//var_dump($dt);exit;
		$html = str_get_html($result);
		$table	=  $html->find('table', 1);
		//var_dump($table->plaintext);exit;

		if(isset($table)){
			$dtK = 1;
			foreach($table->find('tr') as $tr){
				$no 	= $tr->find('td', 0); 
				//var_dump($no);exit;
				if($no != NULL){
					$kodeKel 	= trim($tr->find('td', 0)->plaintext); 
					$namaKel 	= trim($tr->find('td', 1)->plaintext); 
					$klasifikasi 	= trim($tr->find('td', 2)->plaintext); 
					//var_dump($namaKab);exit;
					
					$kodePro 	= cekDt($kodeProD);
					$namaPro 	= cekDt($namaProD);
					$kodeKab 	= cekDt($kodeKabD);
					$namaKab 	= cekDt($namaKabD);
					$kodeKec 	= cekDt($kodeKecD);
					$namaKec 	= cekDt($namaKecD);
					$kodeKel 	= cekDt($kodeKel);
					$namaKel 	= cekDt($namaKel);
					
					$kode 		=  cekDt($kodePro.$kodeKab.$kodeKec.$kodeKel);
					
					$url1		= cekDt($url);
					$_table = "cetak_kel";
					$gr = "REPLACE INTO
						$_table
						(
							kode,
							kodePro,kodeKab,kodeKec,kodeKel,
							namaPro,namaKab,namaKec,namaKel,
							klasifikasi,
							url,
							created_at
						)
						VALUES
						(
							'$kode',
							'$kodePro','$kodeKab','$kodeKec','$kodeKel',
							'$namaPro','$namaKab','$namaKec','$namaKel',
							'$klasifikasi',
							'$url1',
							NOW()			
						)		
					";
					//var_dump($gr);exit;
					$ig = mysqli_query($conn,$gr);
					if($ig){
						echo"=> Data ".$nod.'.'.$dtK." - ".$kodePro." - ".$namaPro.'/'.$kodeKab." - ".$namaKab.'/'.$kodeKec." - ".$namaKec.'<br>';
					}else{
						echo"Failed - ".$url."<br>";
						echo"Failed - ".$gr;exit;
					}
					$dtK++;					
					//exit;			
					/*
					$dirf			= "File Master/Pro/";
					//var_dump($dirf);exit;
					if (!is_dir($dirf)) {
						mkdir($dirf, 0777, true);
					}
					//exit;
					$filename 	= $dirf.$kodeProD.".html";
					//var_dump($filename);exit;
					*/
					$size = getFileSize($filename);
					//var_dump(formatSizeUnits($size));exit;
					if ($size <= 40){
						if (file_exists($filename)) {
							$a = unlink($filename);
							if($a){
								echo "=> The file $filename,with size $size delete<br>";//exit;
							}else{
								echo "=> The file $filename,with size $size can't delete<br>";//exit;	
							}						
						} else {
							echo "=> The file $filename don't exists<br>";//exit;		
						}
					}else {
						echo "=> The file $filename with size $size ready.<br>";//exit;	
					}

					if (!file_exists($filename)) {
						$fp = fopen($filename , "w");
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);
						$size = getFileSize($filename);
						echo "=> The file $filename created <br>";
						echo "=> in url $url with size ".getFileSize($filename) ."B <br>";//exit;	
					} else {
						echo "=> The file $filename exists<br>";//exit;		
						echo "=> In URL <a href='$url'>$url</a><br>";//exit;		
					}
				}
			}
		}
	}else {
		echo "=> The file $filename exists<br>";//exit;		
		echo "=> In URL <a href='$url'>$url</a><br>";//exit;		
	}
	$nod++;
}
?>
</body>
</html>