<?php
if($domain!=='admin'){
	?><script language="javascript">document.location.href="logout.php"</script><?php
}					  
?>

<!--  page-wrapper -->
<div class="row">
     <!-- page header -->
    <div class="col-lg-12">
        <h1 class="page-header">Laporan &raquo; Guru Pembimbing</h1>
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
					<form action="?page=laporan_guru_pembimbing" method="post"><?php 
					?>
                    <div class="form-group">
                      <label>Nama Guru</label>
                      <select name="id_guru" class="form-control">
                      <option value="0">-- Pilih Guru --</option>
                      <?php
					  $guru=mysqli_query($link,"select * from data_guru order by nama_guru asc");
					  while($row1=mysqli_fetch_array($guru)){
					  ?>
                          <option value="<?php echo $row1['id_guru'];?>" <?php if($row1['id_guru']==$id_guru){ echo 'selected';}?>><?php echo $row1['nama_guru'];?> [<?php echo $row1['nip'];?>] </option>
					  <?php
					  }
					  ?>                          
                      </select>
                    </div>

                    <div class="form-group">
                          <label>Nama Siswa</label>
                          <select name="id_siswa"  class="form-control">
                          <option value="0">-- Pilih Siswa --</option>
                      <?php
                      $siswa=mysqli_query($link,"select * from data_siswa siswa, tbl_ruangan ruangan, setup_kelas kelas where ruangan.id_siswa=siswa.id_siswa and ruangan.id_kelas=kelas.id_kelas order by nama_siswa asc");
                      while($row4=mysqli_fetch_array($siswa)){
                      ?>
                          <option value="<?php echo $row4['id_siswa'];?>" <?php if($row4['id_siswa']==$id_siswa){ echo 'selected';}?>><?php echo $row4['nama_siswa'];?> [<?php echo $row4['nis'];?>] [<?php echo $row4['nama_kelas'];?>]</option>
                      <?php
                      }
                      ?>                           
                      </select>
                    </div>
                     
                    <div class="form-group">
                            <input type="submit" name="submit"  value="Filter Data" class="btn btn-primary"/>
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

		

<!--  start product-table ..................................................................................... -->
<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">   
            <div class="panel-body">
                <div class="table-responsive">
                
                <?php
				//untuk filter data bimbingan siswa
                if(isset($_POST['submit'])){
                    $id_guru=htmlentities($_POST['id_guru']);
					$id_siswa=htmlentities($_POST['id_siswa']);
                    
                    if($id_guru!=="0"){
                        $filter_guru="and guru.id_guru='$id_guru'";
                    }else{
                        $filter_guru="";
                    }
					
					if($id_siswa!=="0"){
                        $filter_siswa="and siswa.id_siswa='$id_siswa'";
                    }else{
                        $filter_siswa="";
                    }
                }else{
                    unset($_POST['submit']);
                }
                ?>
                
                <table class="table table-striped table-bordered table-hover" border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                <tr>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Nomor</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Photo Guru</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Nama Guru</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">NIP</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Telpon</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Photo Siswa</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">Nama siswa</a></th>
                    <th class="table-header-repeat line-left minwidth-1"><a href="">NIS</a></th>
                    <th class="table-header-options line-left"><a href="">Aksi</a></th>
                </tr>
                
                
                <?php
                $view=mysqli_query($link,"select id_bimbingan, nama_guru, nip, telpon_guru, guru.photo as poguru, nama_siswa, nis, siswa.photo as posiswa from tbl_siswa_bimbingan bimbingan, data_guru guru, data_siswa siswa where bimbingan.id_siswa=siswa.id_siswa and bimbingan.id_guru=guru.id_guru $filter_guru $filter_siswa order by id_bimbingan asc");
                
                $no=0;
                while($row=mysqli_fetch_array($view)){
                ?>	
               	
                 <tr>
                    <td><?php echo $no=$no+1;?></td>
                    <td>
                        <?php 
                        $poguru=$row['poguru'];
                        if(empty($poguru)){
                            $photo_guru='nopic.jpg';
                        }else{
                            $photo_guru=$poguru;
                        }
                        ?>
                        <div align="center"><img src="./photo_guru/<?php echo $photo_guru;?>" height="101" width="83">
                          </div></td>
                    <td><?php echo $row['nama_guru'];?></td>
                    <td align="center"><?php echo $row['nip'];?></td>
                    <td><?php echo $row['telpon_guru'];?></td>
                    <td>
                        <?php 
                        $posiswa=$row['posiswa'];
                        if(empty($posiswa)){
                            $photo_siswa='nopic.jpg';
                        }else{
                            $photo_siswa=$posiswa;
                        }
                        ?>
                        <div align="center"><img src="./photo_siswa/<?php echo $photo_siswa;?>" height="101" width="83">
                          </div></td>
                    <td><?php echo $row['nama_siswa'];?></td>
                    <td><?php echo $row['nis'];?></td>
                    <td class="options-width">
                    <a href="?page=setup_siswa_bimbingan&mode=delete&id_bimbingan=<?php echo $row['id_bimbingan'];?>" onclick="return confirm('Apakah Anda yakin?')" title="Delete" class="icon-2 info-tooltip"><img src="images/delete.png" /></a>
                    <a href="?page=setup_siswa_bimbingan&mode=edit&id_bimbingan=<?php echo $row['id_bimbingan'];?>" title="Edit" class="icon-5 info-tooltip"><img src="images/edit.png" /></a>            
                    </td>
                </tr>
               
                <?php
                }
                ?>
                </table>
                
                
                </div>
        	</div>
        <!--  end  Context Classes  -->
    	</div>
	</div>
</div>
<!-- end page-wrapper -->