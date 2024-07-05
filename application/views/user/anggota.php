<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <?php if(validation_errors()){?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors();?>
            </div>
            <?php }?>
            <?= $this->session->flashdata('pesan'); ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Is Active ?</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $a = 1;
                    foreach ($anggota as $u) { ?>
                    <tr>
                        <th scope="row"><?= $a++; ?></th>
                        <td><?= $u['nama']; ?></td>
                        <td><?= $u['email']; ?></td>
                        <td><?= $u['is_active']; ?></td>             
                        <td>
                            <a href="<?= base_url('user/ubahAnggota/').$u['id'];?>" class="badge badge-info"><i class="fas fa-edit"></i> Ubah</a>
                            <a href="<?= base_url('user/hapusAnggota/').$u['id'];?>" onclick="return confirm('Kamu yakin akan menghapus <?= $judul.' '.$u['nama'];?> ?');" class="badge badge-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

