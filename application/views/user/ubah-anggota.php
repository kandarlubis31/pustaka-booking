<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <?= form_open_multipart('user/ubahAnggota/'. $username['id']); ?>
            <div class="form-group row">
                <input type="hidden" class="form-control" id="id_user" name="id_user" value="<?= $username['id']; ?>">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $username['nama']; ?>"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" value="<?= $username['email']; ?>"
                        readonly>
                </div>
            </div>
           <div class="form-group row">
                <label for="is_active" class="col-sm-2 col-form-label">Status Anggota</label>
                <div class="col-sm-10">
                    <select name="is_active" class="form-control form-control-user">
                        <option value="<?= $username['is_active']; ?>">Data tidak berubah...</option>
                        <option value="1" <?= set_select('is_active',0, true) ?>>Aktif</option>
                        <option value="0" <?= set_select('is_active',1, true) ?>>Non-Aktifkan</option>
                    </select>
                    <?= form_error('is_active', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-dark" onclick="window.history.go(-1)"> Kembali</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
