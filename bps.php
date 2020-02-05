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
					<input name="kata_kunci" type="text" value="" size="11">
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Cari" name="submit"></td>
			</tr>
		</tbody></table>
</form>
<?php
if(isset($_POST['submit'])){
		
	// set post fields
	$pilihcari = $_POST['pilihcari'];
	$katakunci = $_POST['kata_kunci'];
	$post = [
		'pilihcari' => $pilihcari,
		'kata_kunci' => $katakunci,
		'submit'   => 'Cari',
	];
	$url 	= 'http://mfdonline.bps.go.id/index.php?link=hasil_pencarian';
	$ch 	= curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	// execute!
	$response = curl_exec($ch);

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
?>