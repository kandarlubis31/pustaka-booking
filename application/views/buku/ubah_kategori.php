<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">           
                <!-- Konten -->
                <form action="<?= base_url('buku/ubahkategori/'. $kategori['id']) ?>" method='post'>
                    <div class='form_group'>
                        <input name='id' type='hidden' class='form-control' value="<?= $kategori['id'] ?>">
                        <input name='kategori' class='form-control' value="<?= $kategori['kategori'] ?>">
                        <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group row justify-content-left mt-2">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                            <button class="btn btn-dark" onclick="window.history.go(-1)"> Kembali</button>
                        </div>
                    </div>
                </form>


        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
