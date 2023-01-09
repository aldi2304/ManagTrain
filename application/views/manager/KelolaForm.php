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
        <link href="<?= base_url('assets/'); ?>vendor/datatables/Buttons-2.3.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
        <script>
            function reload_halaman() {
                window.location.reload();
            }
        </script>
    </head>

    <div class="container-fluid">

        <!-- Page Heading -->
        <b style="font-size: 25px; color:#009bbf;">Data Training</b>

        <button class="btn btn-success" onclick="add_ctraining()" style="float: right;"><i class="fa fa-user-md"></i> <b>Data Training</b></button>
        <button class="btn btn-warning" onclick="reload_table()" style="float: right; margin-right:10px;"><i class="fa fa-sync"></i> <b> Refresh </b></button>
        <br> <br>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Training</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Register</th>
                                <th>No HP</th>
                                <th>Training Soft Skill</th>
                                <th>Training Technical Skill</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    </div>
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
                    "url": "<?php echo site_url('manager/ajax_listForm') ?>",
                    "type": "POST"
                    //  "dataSrc": " "

                },

                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                }, ],

            });

        });

        function add_ctraining() {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Training'); // Set Title to Bootstrap modal title
        }

        function edit_ctraining(id_form) {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: "<?php echo site_url('manager/ajax_editcTraining') ?>/" + id_form,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id_form"]').val(data.id_form);
                    $('[name="nama_pegawai"]').val(data.nama_pegawai);
                    $('[name="register"]').val(data.register);
                    $('[name="telp"]').val(data.telp);
                    $('[name="softskill"]').val(data.softskill);
                    $('[name="techskill"]').val(data.techskill);
                    $('[name="keterangan"]').val(data.keterangan);

                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit cTraining'); // Set title to Bootstrap modal title

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data Training');
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
                url = "<?php echo site_url('manager/ajax_addcTraining') ?>";
            } else {
                url = "<?php echo site_url('manager/ajax_updatecTraining') ?>";
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

                    alert('Data Training Berhasil Ditambahkan');
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

        function delete_ctraining(id_form) {
            if (confirm('Apakah anda yakin akan mengahapus data Training?')) {
                // ajax delete data to database
                $.ajax({
                    url: "<?php echo site_url('manager/ajax_deletecTraining') ?>/" + id_form,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        alert('Data Training Berhasil Dihapus');
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
                    <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm"><b style="font-size: 20px; color:black;">Tambah Data Training</b></label>
                    <div class="col-sm-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>



                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="id" style="color: black;">Nama</label>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Register" style="color: black;">Register</label>
                                <input type="text" class="form-control" id="register" name="register" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="No Hp" style="color: black;">No HP</label>
                                <input type="number" class="form-control" id="telp" name="telp" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="softskill" style="color: black;">Training Soft Skill</label>
                                <textarea class="form-control" id="softskill" rows="2" name="softskill" required></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sub_dept" style="color: black;">Training Technical Skill</label>
                                <textarea class="form-control" id="techskill" rows="2" name="techskill" required></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status" style="color: black;">Keterangan</label>
                                <textarea class="form-control" id="keterangan" rows="2" name="keterangan"></textarea>
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