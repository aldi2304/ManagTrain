<head>
    <!-- Custom fonts for this template -->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/'); ?> vendor/DataTables-1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .scroll {
            height: 300px;
            overflow: scroll;
        }
    </style>
</head>


<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><b><?= $title; ?></b></h1>

    <div class="row">
        <div class="col-xl-4 col-md-4 mb-3">
            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Akun User</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $query = $this->db->get('user');
                                echo $query->num_rows(); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pegawai</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $query = $this->db->get('tbl_karyawan');
                                echo $query->num_rows(); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Training</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $query = $this->db->query("SELECT * FROM training group by id_training");
                                echo $query->num_rows(); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="<?= base_url('index.php/Manager/index/') ?>" method="get">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Masukan ID Pegawai...">
            <button class="btn btn-success" type="submit" id="button-addon2">Cari</button>
        </div>
    </form>

    <?php if (!empty($keyword)) { ?>
        <!-- <p style="color:orange"><b>Menampilkan data dengan kata kunci : "<?= $keyword; ?>"</b></p>-->
    <?php } ?>
    <br>

    <div class="scroll">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Register</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Sub Departemen</th>
                                        <th>Status</th>
                                        <th>Cluster</th>
                                        <th>Grade</th>
                                        <th>Gender</th>
                                        <th>Jabatan</th>
                                        <th>Dob</th>
                                        <th>Doj</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($data2 as $tk) : ?>
                                        <tr>
                                            <th><?= $no; ?></th>
                                            <td><?= $tk['id_pegawai']; ?></td>
                                            <td><?= $tk['nama']; ?></td>
                                            <td><?= $tk['dept']; ?></td>
                                            <td><?= $tk['sub_dept']; ?></td>
                                            <td><?= $tk['Status']; ?></td>
                                            <td><?= $tk['cluster']; ?></td>
                                            <td><?= $tk['grade']; ?></td>
                                            <td><?= $tk['gender']; ?></td>
                                            <td><?= $tk['jabatan']; ?></td>
                                            <td><?= $tk['dob']; ?></td>
                                            <td><?= $tk['doj']; ?></td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script src="<?php echo base_url('assets/vendor/jquery/jquery-2.1.4.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap.js') ?>"></script>

            <link href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">

        </div>
    </div>
</div>
</div>