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
            height: 400px;
            overflow: scroll;
        }
    </style>
</head>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><b><?= $title; ?></b></h1>
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-2">
            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Data Pegawai</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $user['name']; ?> <br> <?= $user['email']; ?></div>
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
                                $query = $this->db->query("SELECT * FROM training");
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



    <form action="<?= base_url('index.php/Admin/index/') ?>" method="get">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Masukan No Register Pegawai...">
            <button class="btn btn-success" type="submit" id="button-addon2">Cari</button>
        </div>
    </form>

    <?php if (!empty($keyword)) { ?>
        <!-- <p style="color:orange"><b>Menampilkan data dengan kata kunci : "<?= $keyword; ?>"</b></p>-->
    <?php } ?>
    <br>


    <div class="row">
        <div class="col-xl-6">
            <div class="scroll">
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

                    <script src="<?php echo base_url('assets/vendor/jquery/jquery-2.1.4.min.js') ?>"></script>
                    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
                    <script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
                    <script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap.js') ?>"></script>

                    <link href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="scroll">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Data Training</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id_Training</th>
                                        <th>Topik</th>
                                        <th>Instruktur</th>
                                        <th>Type</th>
                                        <th>Gender</th>
                                        <td>Tanggal</td>
                                        <th>Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->db->select('*');
                                    $this->db->from('training');
                                    if (!empty($keyword)) {
                                        $this->db->like('id_training', $keyword);
                                    }
                                    $simpan = $this->db->get()->result_array();
                                    ?>

                                    <?php foreach ($simpan as $tk) : ?>
                                        <tr>
                                            <td><?= $tk['id_training']; ?></td>
                                            <td><?= $tk['topik']; ?></td>
                                            <td><?= $tk['instruktur']; ?></td>
                                            <td><?= $tk['type']; ?></td>
                                            <td><?= $tk['tanggal']; ?></td>
                                            <td><?= $tk['jam']; ?></td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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


    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">Grafik Jumlah Training</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <!--
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
-->
                    <canvas id="myChart"></canvas>
                    <?php
                    $query = "SELECT id_training AS IDTraining, COUNT(*) AS totalIDTraining FROM training
                    GROUP BY id_training";
                    $result = $this->db->query($query)->result();

                    $Idt = "";            // string kosong untuk menampung data id Karyawan
                    $Nilai = null;    // nilai awal null untuk menampung data nilai

                    // looping data dari $chartSiswa
                    foreach ($result as $chart) {
                        $dataPegawai     = "ID Pegawai " . $chart->IDTraining;
                        $Idt         .= "'$dataPegawai'" . ",";
                        $dataTotal     = $chart->totalIDTraining;
                        $Nilai .= "'$dataTotal'" . ",";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<br> <br>
<!-- CDN CHART JS -->
<script src="<?= base_url('assets/'); ?>vendor/chart.js/cdn.js"></script>
<script type="text/javascript">
    const chartProject = document.getElementById('myChart').getContext('2d');
    const chart = new Chart(chartProject, {
        type: 'bar',
        data: {
            labels: [<?= $Idt; ?>], // data tahun sebagai label dari chart
            datasets: [{
                label: 'Jumlah Training',
                backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)', 'rgb(175, 238, 239)'],
                borderColor: ['rgb(255, 99, 132)'],
                data: [<?= $Nilai; ?>] //data siswa sebagai data dari chart
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>