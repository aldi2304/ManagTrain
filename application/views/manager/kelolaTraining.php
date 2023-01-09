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
</head>

<div class="container-fluid">

    <!-- Page Heading -->
    <b style="font-size: 25px; color:#009bbf;">Kelola Training</b>

    <button class="btn btn-success" onclick="add_training()" style="float: right;"><i class="fa fa-user-md"></i> <b>Training</b></button>
    <button class="btn btn-warning" onclick="reload_table()" style="float: right; margin-right:10px;"><i class="fa fa-sync"></i> <b> Refresh </b></button>
    <br> <br>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Training</h6>
        </div>
        <a class="btn btn-sm btn-success" target="_blank" style="float: left;" href="<?php echo base_url('manager/export_excel') ?>"><i class="fa fa-print"></i> Export</a>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered datatable-static" style="width:100%">
                    <thead>
                        <tr>
                            <th>No Training</th>
                            <th>Topik Training</th>
                            <th>Instruktur/Guru</th>
                            <th>Focus Area</th>
                            <th>Tanggal</th>
                            <th>Jam Training</th>
                            <th>Training Delivery</th>
                            <th>Biaya</th>
                            <th>Status Training</th>
                            <th>Action</th>
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
        $('.datatable-static').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.


            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('manager/ajax_listTraining') ?>",
                "type": "POST"
                //  "dataSrc": " "

            },

            //Set column definition initialisation properties.


        });
    });

    function add_training() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Training'); // Set Title to Bootstrap modal title
    }

    function edit_training(id_training) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('manager/ajax_editTraining') ?>/" + id_training,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_training"]').val(data.id_training);
                $('[name="topik"]').val(data.topik);
                $('[name="instruktur"]').val(data.instruktur);
                $('[name="type"]').val(data.type);
                $('[name="gender"]').val(data.gender);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="jam"]').val(data.jam);
                $('[name="training_delivery"]').val(data.training_delivery);
                $('[name="biaya"]').val(data.biaya);
                $('[name="Status"]').val(data.Status);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Training'); // Set title to Bootstrap modal title

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
            url = "<?php echo site_url('manager/ajax_addTraining') ?>";
        } else {
            url = "<?php echo site_url('manager/ajax_updateTraining') ?>";
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

    function delete_training(id_training) {
        if (confirm('Apakah anda yakin akan mengahapus data training?')) {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('manager/ajax_deleteTraining') ?>/" + id_training,
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
                <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm"><b style="font-size: 20px; color:#009bbf;">Tambah Data Training</b></label>
                <div class="col-sm-6">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>


            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <!-- <input type="hidden" value="" name="id_training" />-->

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="id_training" style="color: black;">No Training</label>
                            <input type="text" class="form-control" id="id_training" name="id_training">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="topik" style="color: black;">Topik Training</label>
                            <textarea class="form-control" id="topik" rows="1" name="topik"></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="instruktur" style="color: black;">Instruktur</label>
                            <input type="text" class="form-control" id="instruktur" name="instruktur">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="type" style="color: black;">Focus Area</label>
                            <select id="type" class="form-control" name="type" required>
                                <option selected> </option>
                                <option value="Functional/Technical">Functional/Technical</option>
                                <option value="Quality/EHS">Quality/EHS</option>
                                <option value="Managerial">Managerial</option>
                                <option value="Behavioral">Behavioral</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tanggal" style="color: black;">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="jam" style="color: black;">Jam Training</label>
                            <select class="form-control form-select-lg mb-3" aria-label=".form-select-lg example" id="jam" name="jam">
                                <option selected> </option>
                                <option value="1 Jam">1 Jam</option>
                                <option value="2 Jam">2 Jam</option>
                                <option value="3 Jam">3 Jam</option>
                                <option value="4 Jam">4 Jam</option>
                                <option value="5 Jam">5 Jam</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="training_delivery" style="color: black;">Training Delivery</label>
                            <select class="form-control form-select-lg mb-3" aria-label=".form-select-lg example" name="training_delivery">
                                <option selected> </option>
                                <option value="Online-Internal"> Online-Internal</option>
                                <option value="Online-External">Online-External</option>
                                <option value="Offline-Internal">Offline-Internal</option>
                                <option value="Offline-External">Offline-External</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tmpt_lahir" style="color: black;">Biaya Training</label>
                            <input type="text" class="form-control" id="biaya" name="biaya">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Status" style="color: black;">Status Training</label>
                            <select id="Status" class="form-control" name="Status" required>
                                <option selected> </option>
                                <option value="Sudah Dilaksanakan">Sudah Dilaksanakan</option>
                                <option value="Akan Dilaksanakan">Akan Dilaksanakan</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</a></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->