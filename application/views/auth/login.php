<div class="container" style="margin-top:100px;">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="assets\img\Indorama.png" width="350px" height="150px">
                                    <h1 class="h4 text-gray-900 mb-4"><b style="color: #808080">Login Management Sistem Training</h1>
                                </div>

                                <?= $this->session->flashdata('message'); ?>


                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Silahkan masukan Email anda" value="<?= set_value('email'); ?>">
                                        <?= form_error('name', ' <small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Silahkan masukkan Password anda">
                                        <?= form_error('password', ' <small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" shadow-lg style="background-color: #009bbf; color:white;">
                                        <b>Login</b>
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password ?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/registration'); ?>">Buat Akun Baru ?</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright text-center my-auto" style="color: #009bbf;">
                <span>Copyright &copy; INFORMATIKA UNJANI <?= date('Y') ?></span>
            </div>
        </div>
    </div>
</div>

</div>