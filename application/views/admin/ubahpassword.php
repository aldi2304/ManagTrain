<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Page Heading-->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>

            <form action="<?= base_url('admin/ubahpassword'); ?>" method="post">
                <div class="form-group">
                    <label for="current_password" style=color:#808080>Password Lama</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Silahkan masukan password lama anda...">
                    <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="new_password1" style=color:#808080>Password Baru</label>
                    <input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="Silahkan masukan password baru...">
                    <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="new_password2" style=color:#808080>Ulangi Password Baru</label>
                    <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Ulangi password baru...">
                    <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>



        </div>
    </div>
</div>
<!-- /.Container-fluid -->

</div>
<!-- End of Main Content -->