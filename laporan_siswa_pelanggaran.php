<?php
if($domain!=='admin'){
	?><script language="javascript">document.location.href="logout.php"</script><?php
}					  
$id_guru=$_SESSION['id_guru'];
?>

<!--  page-wrapper -->
<div class="row">
     <!-- page header -->
    <div class="col-lg-12">
        <h1 class="page-header">Laporan &raquo; Pelanggaran Siswa</h1>
    </div>
    <!--end page header -->
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                    
                    <?php
					include "warning.php";
					?>
					
                    <form action="?page=laporan_siswa_pelanggaran" method="post">
                    <div class="form-group">
                      <label>Nama Guru</label>
                      <select class="form-control" name="id_guru">
                      <option value="0">-- Pilih Guru --</option>
                      <?php
					  $guru=mysqli_query($link,"select * from data_guru");
					  while($row1=mysqli_fetch_array($guru)){
					  ?>
                          <option value="<?php echo $row1['id_guru'];?>" <?php if($row1['id_guru']==$id_guru){ echo 'selected';}?>><?php echo $row1['nama_guru'];?> [<?php echo $row1['nip'];?>] </option>
					  <?php
					  }
					  ?>                          
                      </select>
                    </div>

                    <div class="form-group">
                          <label>Siswa Bimbingan</label>
                          <select name="id_siswa"  class="form-control" name="input">
                          <option value="0">-- Pilih Siswa --</option>
                      <?php
                      $siswa=mysqli_query($link,"select bimbingan.id_bimbingan, siswa.id_siswa, nama_siswa, nis, nama_kelas from tbl_siswa_bimbingan bimbingan, data_siswa siswa, data_guru guru, tbl_ruangan ruangan, setup_kelas kelas where bimbingan.id_siswa=siswa.id_siswa and bimbingan.id_guru=guru.id_guru and ruangan.id_siswa=siswa.id_siswa and ruangan.id_kelas=kelas.id_kelas order by nama_siswa asc");
					  
                      while($row4=mysqli_fetch_array($siswa)){
                      ?>
                          <option value="<?php echo $row4['id_siswa'];?>" <?php if($row4['id_siswa']==$id_siswa){ echo 'selected';}?>><?php echo $row4['nama_siswa'];?> [<?php echo $row4['nis'];?>] [<?php echo $row4['nama_kelas'];?>]</option>
                      <?php
                      }
                      ?>                           
                      </select>
                    </div>
                     
                    <div class="form-group">
                            <input type="submit" name="submit" value="Filter Data" class="btn btn-primary"/>
                    </div>   
					</form>

                    </div>
            	</div>
        	</div>
        <!--  end  Context Classes  -->
    	</div>
	</div>
</div>
<!-- end page-wrapper -->

      
<?php
if(isset($_POST['submit'])){
	$id_siswa=htmlentities($_POST['id_siswa']);
	$id_guru=htmlentities($_POST['id_guru']);
	
	if($id_guru!=="0"){
		$filter_guru="and bimbingan.id_guru='$id_guru'";
	}else{
		$filter_guru="";
	}
	
	if($id_siswa!=="0"){
		$filter_siswa="and bimbingan.id_siswa='$id_siswa'";
	}else{
		$filter_siswa="";
	}
}else{
	unset($_POST['submit']);
}
?>


<!--  start product-table ..................................................................................... -->
<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">   
            <div class="panel-body">
                <div class="table-responsive">
				
                <center>
                <?php
                //************awal paging************//
                $query=mysqli_query($link,"select siswa.photo as posiswa, nama_siswa, nis, nama_kelas, ortu.photo as portu, nama_orangtua from tbl_siswa_bimbingan bimbingan, tbl_ruangan ruangan, tbl_akses_ortu aksesortu, data_orangtua ortu, data_siswa siswa,data_guru guru, setup_kelas kelas where bimbingan.id_siswa=siswa.id_siswa and bimbingan.id_siswa=ruangan.id_siswa and ruangan.id_kelas=kelas.id_kelas and bimbingan.id_siswa=aksesortu.id_siswa and aksesortu.id_orangtua=ortu.id_orangtua and bimbingan.id_guru=guru.id_guru  $filter_siswa $filter_guru order by siswa.nama_siswa asc");
                $get_pages=mysqli_num_rows($query); //dapatkan jumlah semua data
                
                if ($get_pages>$entries)  //jika jumlah semua data lebih banyak dari nilai awal yang diberikan
                {
                    ?>Halaman : <?php
                    $pages=1;
                    while($pages<=ceil($get_pages/$entries))
                    {
                        if ($pages!=1)
                        {
                            echo " | ";
                        }
                    ?>
                    <!--Membuat link sesuai nama halaman-->
                    <a href="?page=laporan_siswa_pelanggaran&halaman=<?php echo ($pages-1); ?> " style="text-decoration:none"><font size="2" face="verdana" color="#009900"><?php echo $pages; ?></font></a>
                    <?php
                    $pages++;
                    }
                    
                }else{
                    $pages=1;
                }
                
                //**************akhir paging*****************//
                ?>
                </font>
                <?php
                $page=(int)$_GET['halaman'];
                $offset=$page*$entries;
                
                //menampilkan data dengan menggunakan limit sesuai parameter paging yang diberikan
                $result=mysqli_query($link,"select id_bimbingan, siswa.photo as posiswa, nama_siswa, nama_guru, nis, nama_kelas, nama_guru, ortu.photo as portu, nama_orangtua from tbl_siswa_bimbingan bimbingan, tbl_ruangan ruangan, tbl_akses_ortu aksesortu, data_orangtua ortu, data_siswa siswa,data_guru guru, setup_kelas kelas where bimbingan.id_siswa=siswa.id_siswa and bimbingan.id_siswa=ruangan.id_siswa and ruangan.id_kelas=kelas.id_kelas and bimbingan.id_siswa=aksesortu.id_siswa and aksesortu.id_orangtua=ortu.id_orangtua and bimbingan.id_guru=guru.id_guru  $filter_siswa $filter_guru order by siswa.nama_siswa asc limit $offset,$entries"); //output
                ?>
                </center>
                
                
                <table class="table table-striped table-bordered table-hover" border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                <tr>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Nomor</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Photo Siswa</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Nama Siswa</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">NIS</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Kelas</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Guru</a></th>
                    <th class="table-header-repeat line-left minwidth-1" align="center"><a href=""><font color="#FF0000">TOTAL POIN</font></a></th>
                    <th class="table-header-options line-left"><a href="">Cetak</a></th>
                </tr>
                
                
                <?php
                $no=0;
                while($row=mysqli_fetch_array($result)){
					$id_bimbingan=$row['id_bimbingan'];
                ?>	
                <tr>
                    <td><?php echo $offset=$offset+1;?></td>
                    
                    <td>
                        <?php 
                        $posiswa=$row['posiswa'];
                        if(empty($posiswa)){
                            $photo_siswa='nopic.jpg';
                        }else{
                            $photo_siswa=$posiswa;
                        }
                        ?>
                        <div align="center"><img src="./photo_siswa/<?php echo $photo_siswa;?>" height="101" width="83"></div>
                    </td>
                    
                    <td><?php echo $nama_siswa=$row['nama_siswa'];?></td>
                    <td><?php echo $nis=$row['nis'];?></td>
                    <td><?php echo $nama_kelas=$row['nama_kelas'];?></td>
                    <td><?php echo $guru_bk=$row['nama_guru'];?></td>
                    <td><b>
                    <?php
					$cek_total=mysqli_fetch_array(mysqli_query($link,"select sum(poin) as total_poin from tbl_siswa_pelanggaran where id_bimbingan='$id_bimbingan'"));
					echo $total=$cek_total['total_poin'];
					?></b>
                    </td>
                    <td>
                    
                    <a href="javascript:;"  title="Cetak Laporan Pelanggaran ke File PDF"><img src="images/pdf-icon.jpeg" border="0" onClick="window.open('./pdf/export_pdf_pelanggaran.php?id_bimbingan=<?php echo $id_bimbingan;?>&nama_kelas=<?php echo $nama_kelas;?>&nama_siswa=<?php echo $nama_siswa;?>&nis=<?php echo $nis;?>&nama_guru=<?php echo $guru_bk;?>&photo=<?php echo $photo_siswa;?>&logo=<?php echo $photo_siswa;?>','scrollwindow','top=200,left=300,width=800,height=500');"></a>
            
                    </td>
                </tr>
                <?php
                }
                ?>
                </table>
                
                <center>TOTAL DATA : <?php echo $get_pages;?></center>
                
                </div>
        	</div>
        <!--  end  Context Classes  -->
    	</div>
	</div>
</div>
<!-- end page-wrapper -->
