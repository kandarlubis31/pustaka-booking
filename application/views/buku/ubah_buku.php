<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <img src="<?= base_url('assets/img/upload/') . $buku['image']; ?>" class="img-thumbnail" alt="">
        </div>
        <div class="col-lg-9">
            <?= form_open_multipart('buku/ubahBuku/'. $buku['id']); ?>
            <input type="hidden" class="form-control" id="no_buku" name="no_buku" value="<?= $buku['id']; ?>">
            <div class="form-group row">
                <label for="judul_buku" class="col-sm-2 col-form-label">Judul Buku</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?= $buku['judul_buku']; ?>" placeholder="Masukkan Judul Buku">
                    <?= form_error('judul_buku', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>      
            </div>
            <div class="form-group row">
                <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= $buku['pengarang']; ?>" placeholder="Masukkan Nama Pengarang">
                    <?= form_error('pengarang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $buku['penerbit']; ?>" placeholder="Masukkan Nama Penerbit">
                    <?= form_error('penerbit', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                <div class="col-sm-10">
                    <select name="tahun_terbit" class="form-control form-control-user">
                        <option value="<?= $buku['tahun_terbit']; ?>">Data tidak berubah...</option>
                        <?php for ($i=date('Y'); $i > 1000 ; $i--) { ?>
                            <option value="<?= $i;?>"><?= $i;?></option>
                        <?php } ?>
                    </select>
                    <?= form_error('tahun_terbit', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="isbn" class="col-sm-2 col-form-label">Nomor ISBN</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?= $buku['isbn']; ?>" placeholder="Masukkan ISBN">
                    <?= form_error('isbn', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>   
            </div>
            <div class="form-group row">
                <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stok" name="stok" value="<?= $buku['stok']; ?>" placeholder="Masukkan Jumlah Stok">
                     <?= form_error('stok', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Pilih file</label>
                            </div>
                        </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-dark" onclick="location.href='../'"> Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
