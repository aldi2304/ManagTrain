<style>
    .scroll {
        height: 320px;
        overflow: scroll;
    }
</style>

<head>
    <!-- Custom fonts for this template -->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script>
        function reload_halaman() {
            window.location.reload();
        }
    </script>


    <div class="container-fluid">

        <?= $this->session->flashdata('message'); ?>

        <!-- Page Heading -->
        <b style="font-size: 25px; color:#009bbf;">Kelola Pegawai</b>

        <button class="btn btn-info" onclick="add_pegawai()" style="float: right;"><i class="fa fa-user-plus"></i> <b>Pegawai</b></button>
        <button class="btn btn-warning" onclick="reload_table()" style="float: right; margin-right:10px;"><i class="fa fa-sync"></i> <b>Refresh </b></button>
        <br>
        <br>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Informasi Data Pegawai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
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
                                <th>Date of Birth </th>
                                <th>Date of Join </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    </div>
    <!-- Jquery & Datatable -->
    <!-- End of Main Content -->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery-2.1.4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap.js') ?>"></script>

    <link href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">

    <script type="text/javascript">
        var save_method; //for save method string
        var table;

        $(document).ready(function() {

            //datatables 
            table = $('#table').DataTable({
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('manager/ajax_listPegawai') ?>",
                    "type": "POST"
                    //  "dataSrc": " "
                },

            });
        });

        function add_pegawai() {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Pegawai'); // Set Title to Bootstrap modal title
        }

        function edit_pegawai(id_pegawai) {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: "<?php echo site_url('manager/ajax_editPegawai') ?>/" + id_pegawai,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id_pegawai"]').val(data.id_pegawai);
                    $('[name="nama"]').val(data.nama);
                    $('[name="grade"]').val(data.grade);
                    $('[name="cluster"]').val(data.cluster);
                    $('[name="dept"]').val(data.dept);
                    $('[name="sub_dept"]').val(data.sub_dept);
                    $('[name="Status"]').val(data.Status);
                    $('[name="gender"]').val(data.gender);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="dob"]').val(data.dob);
                    $('[name="doj"]').val(data.doj);


                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Pegawai'); // Set title to Bootstrap modal title

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data pegawai');
                }
            });
        }

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function save() {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;

            if (save_method == 'add') {
                url = "<?php echo site_url('manager/ajax_addPegawai') ?>";
            } else {
                url = "<?php echo site_url('manager/ajax_updatePegawai') ?>";
            }

            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {

                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                        reload_halaman();
                    }

                    alert('Data Berhasil Ditambahkan');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 

                }
            });
        }

        function delete_pegawai(id_pegawai) {
            if (confirm('Apakah anda yakin akan menghapus data pegawai?')) {
                // ajax delete data to database
                $.ajax({
                    url: "<?php echo site_url('manager/ajax_deletePegawai') ?>/" + id_pegawai,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        alert('Data Berhasil Dihapus');
                        reload_table();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });

            }
        }
    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm"><b style="font-size: 20px; color:black;">Tambah Data Pegawai</b></label>
                    <div class="col-sm-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>


                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="id" style="color: black;">Register</label>
                                <input type="text" class="form-control" id="id_pegawai" name="id_pegawai">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nama" style="color: black;">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="grade" style="color: black;">Grade</label>
                                <select id="inputState" class="form-control" name="grade" required>
                                    <option selected> </option>
                                    <option value="M02">M02</option>
                                    <option value="M03">M03</option>
                                    <option value="M04">M04</option>
                                    <option value="M05">M05</option>
                                    <option value="M06">M06</option>
                                    <option value="M07">M07</option>
                                    <option value="M08">M08</option>
                                    <option value="M09">M09</option>
                                    <option value="M09A">M09A</option>
                                    <option value="M10">M10</option>
                                    <option value="M11">M11</option>
                                    <option value="M12">M12</option>
                                    <option value="M13">M13</option>
                                    <option value="M14">M14</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="cluster" style="color: black;">Cluster</label>
                                <select id="inputState" class="form-control" name="cluster" required>
                                    <option selected> </option>
                                    <option value="C2">C2</option>
                                    <option value="C3">C3</option>
                                    <option value="C4">C4</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="dept" style="color: black;">Departemen</label>
                                <select id="inputState" class="form-control" name="dept" required>
                                    <option selected> </option>
                                    <option value="DYEING">DYEING</option>
                                    <option value="ENG">ENG</option>
                                    <option value="FAC-GAO">FAC-GAO</option>
                                    <option value="HSE-TRG">HSE-TRG</option>
                                    <option value="LTR">LTR</option>
                                    <option value="PERSONALIA">PERSONALIA</option>
                                    <option value="RND">RND</option>
                                    <option value="SECURITY">SECURITY</option>
                                    <option value="SFG">SFG</option>
                                    <option value="SPG1">SPG1</option>
                                    <option value="SPG4">SPG4</option>
                                    <option value="SPG5">SPG5</option>
                                    <option value="SPG6">SPG6</option>
                                    <option value="SPG7">SPG7</option>
                                    <option value="SRM">SRM</option>
                                    <option value="TFO">TFO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sub_dept" style="color: black;">Sub Departemen</label>
                                <select id="inputState" class="form-control" name="sub_dept" required>
                                    <option selected> </option>
                                    <option value="BCO">BCO</option>
                                    <option value="DDL">DDL</option>
                                    <option value="DDM">DDM</option>
                                    <option value="DDP">DDP</option>
                                    <option value="DRW">DRW</option>
                                    <option value="DSW">DSW</option>
                                    <option value="E10A">E10A</option>
                                    <option value="E10E">E10E</option>
                                    <option value="E1A">E1A</option>
                                    <option value="E1E">E1E</option>
                                    <option value="E2A">E2A</option>
                                    <option value="E2E">E2E</option>
                                    <option value="E3A">E3A</option>
                                    <option value="E5A">E5A</option>
                                    <option value="E5E">E5E</option>
                                    <option value="E6A">E6A</option>
                                    <option value="E6E">E6E</option>
                                    <option value="E7A">E7A</option>
                                    <option value="E7E">E7E</option>
                                    <option value="ECV">ECV</option>
                                    <option value="EEL">EEL</option>
                                    <option value="EWS">EWS</option>
                                    <option value="FAC">FAC</option>
                                    <option value="GAO">GAO</option>
                                    <option value="GH">GH</option>
                                    <option value="GO">GO</option>
                                    <option value="GP1">GP1</option>
                                    <option value="GP10">GP10</option>
                                    <option value="GP5">GP5</option>
                                    <option value="GP6">GP6</option>
                                    <option value="GP7">GP7</option>
                                    <option value="GSC">GSC</option>
                                    <option value="IAD">IAD</option>
                                    <option value="LPM">LPM</option>
                                    <option value="LTR">LTR</option>
                                    <option value="M10B">M10B</option>
                                    <option value="M10C">M10C</option>
                                    <option value="M10R">M10R</option>
                                    <option value="M10S">M10S</option>
                                    <option value="M10W">M10W</option>
                                    <option value="M1C">M1C</option>
                                    <option value="M1D">M1D</option>
                                    <option value="M1F">M1F</option>
                                    <option value="M1R">M1R</option>
                                    <option value="M1W">M1W</option>
                                    <option value="M2B">M2B</option>
                                    <option value="M2D">M2D</option>
                                    <option value="M2R">M2R</option>
                                    <option value="M2W">M2W</option>
                                    <option value="M3C">M3C</option>
                                    <option value="M3D">M3D</option>
                                    <option value="M3M">M3M</option>
                                    <option value="M3R">M3R</option>
                                    <option value="M3S">M3S</option>
                                    <option value="M5B">M5B</option>
                                    <option value="M5C">M5C</option>
                                    <option value="M5D">M5D</option>
                                    <option value="M5R">M5R</option>
                                    <option value="M5S">M5S</option>
                                    <option value="M5W">M5W</option>
                                    <option value="M6B">M6B</option>
                                    <option value="M6C">M6C</option>
                                    <option value="M6M">M6M</option>
                                    <option value="M6R">M6R</option>
                                    <option value="M6S">M6S</option>
                                    <option value="M6W">M6W</option>
                                    <option value="M7B">M7B</option>
                                    <option value="M7C">M7C</option>
                                    <option value="M7D">M7D</option>
                                    <option value="M7R">M7R</option>
                                    <option value="M7S">M7S</option>
                                    <option value="M7W">M7W</option>
                                    <option value="P10B">P10B</option>
                                    <option value="P10C">P10C</option>
                                    <option value="P10D">P10D</option>
                                    <option value="P10G">P10G</option>
                                    <option value="P10M">P10M</option>
                                    <option value="P10R">P10R</option>
                                    <option value="P10S">P10S</option>
                                    <option value="P10W">P10W</option>
                                    <option value="P1B">P1B</option>
                                    <option value="P1C">P1C</option>
                                    <option value="P1D">P1D</option>
                                    <option value="P1G">P1G</option>
                                    <option value="P1R">P1R</option>
                                    <option value="P1S">P1S</option>
                                    <option value="P1W">P1W</option>
                                    <option value="P2B">P2B</option>
                                    <option value="P2C">P2C</option>
                                    <option value="P2D">P2D</option>
                                    <option value="P2G">P2G</option>
                                    <option value="P2M">P2M</option>
                                    <option value="P2R">P2R</option>
                                    <option value="P2S">P2S</option>
                                    <option value="P2W">P2W</option>
                                    <option value="P3B">P3B</option>
                                    <option value="P3C">P3C</option>
                                    <option value="P3D">P3D</option>
                                    <option value="P3G">P3G</option>
                                    <option value="P3M">P3M</option>
                                    <option value="P3R">P3R</option>
                                    <option value="P3S">P3S</option>
                                    <option value="P3W">P3W</option>
                                    <option value="P5B">P5B</option>
                                    <option value="P5C">P5C</option>
                                    <option value="P5D">P5D</option>
                                    <option value="P5G">P5G</option>
                                    <option value="P5M">P5M</option>
                                    <option value="P5R">P5R</option>
                                    <option value="P5S">P5S</option>
                                    <option value="P5W">P5W</option>
                                    <option value="P6B">P6B</option>
                                    <option value="P6C">P6C</option>
                                    <option value="P6D">P6D</option>
                                    <option value="P6G">P6G</option>
                                    <option value="P6M">P6M</option>
                                    <option value="P6R">P6R</option>
                                    <option value="P6S">P6S</option>
                                    <option value="P6W">P6W</option>
                                    <option value="P7B">P7B</option>
                                    <option value="P7C">P7C</option>
                                    <option value="P7D">P7D</option>
                                    <option value="P7G">P7G</option>
                                    <option value="P7R">P7R</option>
                                    <option value="P7S">P7S</option>
                                    <option value="P7W">P7W</option>
                                    <option value="PC">PC</option>
                                    <option value="R&D">R&D</option>
                                    <option value="SFG">SFG</option>
                                    <option value="SRM">SRM</option>
                                    <option value="TF1">TF1</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="status" style="color: black;">Status</label>
                                <select id="inputState" class="form-control" name="Status" required>
                                    <option selected> </option>
                                    <option value="CNTR">CNTR</option>
                                    <option value="OPR">OPR</option>
                                    <option value="SR">SR</option>
                                    <option value="STAFF">STAFF</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gender" style="color: black;">Jenis Kelamin</label>
                                <select id="inputState" class="form-control" name="gender" required>
                                    <option selected> </option>
                                    <option value="Laki-Laki"> Laki-Laki</option>
                                    <option value="Perempuan"> Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jabatan" style="color: black;">Jabatan</label>
                                <select id="inputState" class="form-control" name="jabatan" required>
                                    <option selected> </option>
                                    <option value="ADM. STAFF">ADM. STAFF</option>
                                    <option value="ANALYST">ANALYST</option>
                                    <option value="ASISTEN MANAGER">ASISTEN MANAGER</option>
                                    <option value="ASST. FITTER">ASST. FITTER</option>
                                    <option value="ASST. GENERAL MANAGER">ASST. GENERAL MANAGER</option>
                                    <option value="ASST. LEADER">ASST. LEADER</option>
                                    <option value="ASST. ADM STAFF">ASST. ADM STAFF</option>
                                    <option value="ASST. ANALYS">ASST. ANALYS</option>
                                    <option value="ASST. TECHNICIAN">ASST. TECHNICIAN</option>
                                    <option value="CHECKER">CHECKER</option>
                                    <option value="CLERK">CLERK</option>
                                    <option value="DANRU">DANRU</option>
                                    <option value="DEPUTY MANAGER">DEPUTY MANAGER</option>
                                    <option value="DOFFER">DOFFER</option>
                                    <option value="DY GEN MGR">DY GEN MGR</option>
                                    <option value="FITTER">FITTER</option>
                                    <option value="GUARD">GUARD</option>
                                    <option value="HEAD FITTER">HEAD FITTER</option>
                                    <option value="HELPER">HELPER</option>
                                    <option value="JR ADM STAFF">JR ADM STAFF</option>
                                    <option value="JR TECHNICIAN">JR TECHNICIAN</option>
                                    <option value="KEPALA DOFFER">KEPALA DOFFER</option>
                                    <option value="KOORD. MESS">KOORD. MESS</option>
                                    <option value="LABORATORIST">LABORATORIST</option>
                                    <option value="LEADER">LEADER</option>
                                    <option value="MANAGER">MANAGER</option>
                                    <option value="NURSE">NURSE</option>
                                    <option value="OFFICE BOY">OFFICE BOY</option>
                                    <option value="OFFICER">OFFICER</option>
                                    <option value="OFFICER TRAINE">OFFICER TRAINE</option>
                                    <option value="OPERATOR">OPERATOR</option>
                                    <option value="OPERATOR TELEPHONE">OPERATOR TELEPHONE</option>
                                    <option value="PACKER">PACKER</option>
                                    <option value="SECRETARY">SECRETARY</option>
                                    <option value="SENIOR MANAGER">SENIOR MANAGER</option>
                                    <option value="SENIOR OFFICER">SENIOR OFFICER</option>
                                    <option value="SR. DRIVER">SR. DRIVER</option>
                                    <option value="SR. SECRETARY">SR. SECRETARY</option>
                                    <option value="SUPERVISOR ADMINISTR">SUPERVISOR ADMINISTR</option>
                                    <option value="SUPERVISOR. PROD">SUPERVISOR. PROD</option>
                                    <option value="SUPERVISOR. ADM">SUPERVISOR. ADM</option>
                                    <option value="SUPERVISOR. ANALYST">SUPERVISOR. ANALYST</option>
                                    <option value="SUPERVISOR. LAB">SUPERVISOR. LAB</option>
                                    <option value="SUPERVISOR. SECURITY">SUPERVISOR. SECURITY</option>
                                    <option value="SUPERVISOR. TECH">SUPERVISOR. TECH</option>
                                    <option value="TEHNICIAN">TEHNICIAN</option>
                                    <option value="TIME OFFICE">TIME OFFICE</option>
                                    <option value="WADANRU">WADANRU</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dob" style="color: black;">Date of Birth </label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doj" style="color: black;">Date of Join </label>
                                <input type="date" class="form-control" id="doj" name="doj" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->