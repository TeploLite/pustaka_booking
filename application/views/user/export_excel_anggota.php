<?php  

  header ("Cache-Control: no-cache, must-revalidate");

    header ("Pragma: no-cache");

    header ("Content-type: application/x-msexcel");

    header ("Content-type: application/octet-stream");

    header ("Content-Disposition: attachment; filename=$title.xls");

?>



<h3><center>Laporan Data Anggota Perputakaan Online</center></h3> 

<br/> 

<table class="table-data"> 

	<thead> 

		<tr> 

			<th>No</th> 

			<th>Nama</th> 

			<th>Email</th> 

			<th>Member Sejak</th>

		</tr> 

	</thead> 

	<tbody> 

		<?php
                    $i = 1;
                    foreach ($anggota as $a) { ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $a['nama']; ?></td>
                            <td><?= $a['email']; ?></td>
                            <td><?= date('d F Y', $a['tanggal_input']); ?></td>
                           
                <?php } ?>


	</tbody> 

</table> 

