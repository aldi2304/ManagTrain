<head>
    <!-- Custom fonts for this template -->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url('assets/'); ?>js/demo/chart-pie-demo.js"></script>

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



    <?php if (!empty($keyword)) { ?>
        <!-- <p style="color:orange"><b>Menampilkan data dengan kata kunci : "<?= $keyword; ?>"</b></p>-->
    <?php } ?>
    <br>
    <b style="font-size: 15px; color:#009bbf;">
        <h7>Hasil Pencarian : <?= $total_rows; ?> Data Training</h7>

        <div class="scroll">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Training</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable-static" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Training</th>
                                            <th>Topik Training</th>
                                            <th>Instruktur/Guru</th>
                                            <th>Focus Area</th>
                                            <th>Tanggal</th>
                                            <th>Jam Training</th>
                                            <th>Training Delivery</th>
                                            <th>Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($training as $tk) : ?>
                                            <tr>
                                                <th><?= $no; ?></th>
                                                <td><?= $tk['id_training']; ?></td>
                                                <td><?= $tk['topik']; ?></td>
                                                <td><?= $tk['instruktur']; ?></td>
                                                <td><?= $tk['type']; ?></td>
                                                <td><?= $tk['tanggal']; ?></td>
                                                <td><?= $tk['jam']; ?></td>
                                                <td><?= $tk['training_delivery']; ?></td>
                                                <td><?= $tk['biaya']; ?></td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-2.1.4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap.js') ?>"></script>

<link href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">


<script>
    $(document).ready(function() {


        $('.datatable-static').DataTable({
            'lengthMenu': [
                [10, 25, 50, 100, 200, 500, 1000, -1],
                [10, 25, 50, 100, 200, 500, 1000, 'All'],
            ],
        });



    });
</script>