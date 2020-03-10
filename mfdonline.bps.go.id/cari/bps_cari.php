<form action="" method="post">
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody><tr><td colspan="2" style="font-weight: bold;" align="left">Pencarian</td></tr>
			<tr>
				<td style="padding-right: 7%;"><label for="pilihcari" class="style1"><i>Berdasarkan</i></label></td>
				<td>
					<select name="pilihcari" style="width:90px">
						<option value="prop" style="font-family: calibri">Provinsi</option>
						<option value="kab" style="font-family: calibri">Kabupaten</option>
						<option value="kec" style="font-family: calibri">Kecamatan</option>
						<option value="desa" style="font-family: calibri">Desa</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label class="style1"><i>Keyword</i></label></td>
				<td>
					<input name="kata_kunci" type="text" value="" size="11" required>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Cari" name="submit"></td>
			</tr>
		</tbody></table>
</form>
<?php
include_once('simple_html_dom.php');
include("conn.php");
if(isset($_POST['submit'])){
		
	// set post fields
	$pilihcari = $_POST['pilihcari'];
	$katakunci = $_POST['kata_kunci'];
	$post = [
		'pilihcari' => $pilihcari,
		'kata_kunci' => $katakunci,
		'submit'   => 'Cari',
	];
	//$url 	= 'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian';
	$url 	= 'https://mfdonline.bps.go.id/index.php?link=hasil_pencarian';
	echo "Mencari <b>".$pilihcari."</b> kata kunci <b>". $katakunci."</b><br>";
	$filename 	= $pilihcari.'_'.$katakunci.'.html';
	if(!file_exists($filename)){		
		$ch 	= curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!
		$response = curl_exec($ch);
		
		//var_dump($result);exit;

		$grab     = $response ;
		$start    = '<table border="0" cellspacing="1" cellpadding="5" align="center" width="500">';
		$end      = '<div style="clear: both;">&nbsp;</div>';

		$startPosisition 	= strpos($grab, $start);
		$endPosisition   	= strpos($grab, $end);
		$longText 			= $endPosisition - $startPosisition;
		$resultGrab   		= substr($grab, $startPosisition, $longText);
		$resultGrab   		= trim($resultGrab);
		$resultGrab   		= str_replace("</div>","",$resultGrab);
		$resultGrab   		= strval($resultGrab);

		//var_dump($resultGrab );exit;
		// close the connection, release resources used
		$filename 	= $pilihcari.'_'.$katakunci.'.html';
		$myfile 	= fopen($filename, "w") or die("Unable to open file!");
		fwrite($myfile, $resultGrab);
		fclose($myfile);
	}
	
	
	//$html = str_get_html($filename);
	$html = file_get_html($filename);
	//var_dump($filename);exit;
	//var_dump($html);exit;
	$table	=  $html->find('table', 1);
	if(!isset($table)){
		$table	=  $html->find('table', 0);
	}
	//var_dump($table->plaintext);exit;
	if(isset($table)){
		$dtK = 1;
		foreach($table->find('tr') as $tr){
			$no 	= $tr->find('td', 0); 
			//var_dump($no);exit;
			if($no != NULL){	

				$kodePro 	= trim($tr->find('td', 1)->plaintext); 
				$namaPro 	= trim($tr->find('td', 2)->plaintext);
				$kodeKab 	= trim(isset($tr->find('td', 3)->plaintext) ? $tr->find('td', 3)->plaintext:NULL);
				$namaKab 	= trim(isset($tr->find('td', 4)->plaintext) ? $tr->find('td', 4)->plaintext:NULL);
				$kodeKec 	= trim(isset($tr->find('td', 5)->plaintext) ? $tr->find('td', 5)->plaintext:NULL);
				$namaKec 	= trim(isset($tr->find('td', 6)->plaintext) ? $tr->find('td', 6)->plaintext:NULL);
				$kodeKel 	= trim(isset($tr->find('td', 7)->plaintext) ? $tr->find('td', 7)->plaintext:NULL);
				$namaKel 	= trim(isset($tr->find('td', 8)->plaintext) ? $tr->find('td', 8)->plaintext:NULL);
				//var_dump($kodePro);exit;
				//var_dump($namaPro);exit;
			
				$kodePro 	= cekDt($kodePro);
				$namaPro 	= cekDt($namaPro);
				$kodeKab 	= cekDt($kodeKab);
				$namaKab 	= cekDt($namaKab);
				$kodeKec 	= cekDt($kodeKec);
				$namaKec 	= cekDt($namaKec);
				$kodeKel 	= cekDt($kodeKel);
				$namaKel 	= cekDt($namaKel);
				
				$url1		= cekDt($url);
				
				if($pilihcari=='prop'){
					$_table = "cari_pro";
					$insert = 'kodePro,namaPro,url,created_at';
					$dataInsert = "'$kodePro','$namaPro','$url1',NOW()";
				}elseif($pilihcari=='kab'){					
					$_table = "cari_kab";
					$kode = cekDt($kodePro.$kodeKab);
					$insert = 'kode,kodePro,kodeKab,namaPro,namaKab,url,created_at';
					$dataInsert = "'$kode','$kodePro','$kodeKab','$namaPro','$namaKab','$url1',NOW()";
				}elseif($pilihcari=='kec'){					
					$_table = "cari_kec";
					$kode = cekDt($kodePro.$kodeKab.$kodeKec);
					$insert = 'kode,kodePro,kodeKab,kodeKec,namaPro,namaKab,namaKec,url,created_at';
					$dataInsert = "'$kode','$kodePro','$kodeKab','$kodeKec','$namaPro','$namaKab','$namaKec','$url1',NOW()";
				}elseif($pilihcari=='desa'){					
					$_table = "cari_kel";
					$kode = cekDt($kodePro.$kodeKab.$kodeKec.$kodeKel);
					$insert = 'kode,kodePro,kodeKab,kodeKec,kodeKel,namaPro,namaKab,namaKec,namaKel,url,created_at';
					$dataInsert = "'$kode','$kodePro','$kodeKab','$kodeKec','$kodeKel','$namaPro','$namaKab','$namaKec','$namaKel','$url1',NOW()";
				}else{
					echo "Zzzzzz.........";exit;
				}
				
				$gr = "REPLACE INTO
					$_table
					(
						$insert
					)
					VALUES
					(
						$dataInsert		
					)		
				";
				//var_dump($gr);exit;
				$ig = mysqli_query($conn,$gr);
				if($ig){
					echo"=> Data ".$dtK." - ".$kodePro." - ".$namaPro."/".$kodeKab." - ".$namaKab."/".$kodeKec." - ".$namaKec."/".$kodeKel." - ".$namaKel.'<br>';
				}else{
					echo"Failed - ".$url."<br>";
					echo"Failed - ".$gr;exit;
				}
				$dtK++;
			}
		}
	}
}
?>