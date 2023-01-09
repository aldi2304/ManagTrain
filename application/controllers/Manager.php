<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manager extends CI_Controller
{
    public function __construct()
    //fungsinya buat manggil liblary,model / apapun itu yang di gunain di setiap function. jadi di setiap function tidak perlu mendeklarasikan perintah
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }
    public function index()
    {
        $data['title'] = 'Dashboard Manager';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data2 = $this->searchModel->ambil_data($keyword);
        $data2 = array(
            'keyword'    => $keyword,
            'data2'        => $data2
        );

        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Manager';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('manager/index', $data2);
        $this->load->view('templates/footer', $data);
    }

    public function lihatPegawai()
    {
        $this->load->helper('url');
        $data['title'] = 'Daftar Pegawai';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data2 = $this->searchModel->ambil_data2()($keyword);
        $data2 = array(
            'keyword'    => $keyword,
            'data2'        => $data2
        );

        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Manager';

        $data['karyawan'] = $this->db->get('tbl_karyawan')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('manager/lihatPegawai', $data2);
        $this->load->view('templates/footer', $data);
    }

    public function lihatTraining()
    {
        $this->load->helper('url');
        $data['title'] = 'Lihat Training';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman manager';

        $data['training'] = $this->db->get('tbl_training')->result_array();

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data2 = $this->searchModel->ambil_data($keyword);
        $data2 = array(
            'keyword'    => $keyword,
            'data2'        => $data2
        );

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('manager/lihatTraining', $data);
        $this->load->view('templates/footer', $data);
    }

    public function kelolaPegawai()
    {
        $this->load->helper('url');
        $data['title'] = 'Kelola Pegawai';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Admin';

        $data['karyawan'] = $this->db->get('tbl_karyawan')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('manager/kelolaPegawai', $data);
        $this->load->view('templates/footer', $data);
    }

    //Ajax List Pegawai
    public function ajax_listPegawai()
    {
        $this->load->model("pegawaiModel", "manager", TRUE);
        $list = $this->manager->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $manager) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $manager->id_pegawai;
            $row[] = $manager->nama;
            $row[] = $manager->grade;
            $row[] = $manager->cluster;
            $row[] = $manager->dept;
            $row[] = $manager->sub_dept;
            $row[] = $manager->Status;
            $row[] = $manager->gender;
            $row[] = $manager->jabatan;
            $row[] = $manager->dob;
            $row[] = $manager->doj;


            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" style="margin-bottom:5px;" title="Edit"  onclick="edit_pegawai(' . "'" . $manager->id_pegawai . "'" . ')"><i class="fa fa-edit"></i> Ubah</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"  onclick="delete_pegawai(' . "'" . $manager->id_pegawai . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->count_all(),
            "recordsFiltered" => $this->manager->count_filtered(),
            "data" => $data,
        );
        //output to json format 
        echo json_encode($output);
    }

    public function ajax_listPegawai2()
    {
        $this->load->model("pegawaiModel", "manager", TRUE);
        //  $this->load->model("searchModel", "search", TRUE);
        $list = $this->search->get_datatables();

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data = $this->searchModel->ambil_data($keyword);
        $data = array(
            'keyword'    => $keyword,
            'data'        => $data
        );

        //$data = array();
        $no = $_POST['start'];
        foreach ($list as $search) {
            $no++;
            $row = array();
            $row[] = $search->id_pegawai;
            $row[] = $search->nama;
            $row[] = $search->dept;
            $row[] = $search->Status;
            $row[] = $search->jabatan;

            //add html for action
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->search->count_all(),
            "recordsFiltered" => $this->search->count_filtered(),
            "data" => $data,
        );
        //output to json format 
        echo json_encode($output);
    }

    //Ajax Edit Pegawai
    public function ajax_editPegawai($id_pegawai)
    {
        $this->load->model("pegawaiModel", "manager", TRUE);
        $data = $this->manager->get_by_id($id_pegawai);
        echo json_encode($data);
    }

    //Ajax Tambah Pegawai
    public function ajax_addPegawai()
    {
        $this->load->model("pegawaiModel", "manager", TRUE);
        $data = array(
            'id_pegawai' => $this->input->post('id_pegawai'),
            'nama' => $this->input->post('nama'),
            'grade' => $this->input->post('grade'),
            'cluster' => $this->input->post('cluster'),
            'dept' => $this->input->post('dept'),
            'sub_dept' => $this->input->post('sub_dept'),
            'Status' => $this->input->post('Status'),
            'gender' => $this->input->post('gender'),
            'jabatan' => $this->input->post('jabatan'),
            'dob' => $this->input->post('dob'),
            'doj' => $this->input->post('doj'),
        );

        $insert = $this->manager->save($data);
        echo json_encode(array("status" => TRUE));
    }

    //Ajax Update Pegawai
    public function ajax_updatePegawai()
    {
        $this->load->model("pegawaiModel", "manager", TRUE);
        $data = array(
            'id_pegawai' => $this->input->post('id_pegawai'),
            'nama' => $this->input->post('nama'),
            'grade' => $this->input->post('grade'),
            'cluster' => $this->input->post('cluster'),
            'dept' => $this->input->post('dept'),
            'sub_dept' => $this->input->post('sub_dept'),
            'Status' => $this->input->post('Status'),
            'gender' => $this->input->post('gender'),
            'jabatan' => $this->input->post('jabatan'),
            'dob' => $this->input->post('dob'),
            'doj' => $this->input->post('doj'),
        );
        $this->manager->update(array('id_pegawai' => $this->input->post('id_pegawai')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_deletePegawai($id_pegawai)
    {
        $this->load->model("pegawaiModel", "manager", TRUE);
        $this->manager->delete_by_id($id_pegawai);
        echo json_encode(array("status" => TRUE));
    }


    public function kelolaTraining()
    {
        $this->load->model("trainingModel", "manager", TRUE);
        $data['title'] = 'Kelola Training';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        // $data['trainig'] = $this->db->query("SELECT * FROM training group by id_training")->result_array();

        $data['training'] = $this->db->get('training')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('manager/kelolaTraining', $data);
        $this->load->view('templates/footer', $data);
    }

    //Ajax List Training
    public function ajax_listTraining()
    {
        $this->load->model("trainingModel", "manager", TRUE);
        $list = $this->manager->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $manager) {
            $no++;
            $row = array();
            $row[] = $manager->id_training;
            $row[] = $manager->topik;
            $row[] = $manager->instruktur;
            $row[] = $manager->type;
            $row[] = $manager->tanggal;
            $row[] = $manager->jam;
            $row[] = $manager->training_delivery;
            $row[] = $manager->biaya;
            $row[] = $manager->Status;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" style="margin-bottom:5px;" title="Edit"  onclick="edit_training(' . "'" . $manager->id_training . "'" . ')"><i class="fa fa-edit"></i> Ubah </a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"  onclick="delete_training(' . "'" . $manager->id_training . "'" . ')"><i class="fa fa-trash"></i> Hapus </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->count_all(),
            "recordsFiltered" => $this->manager->count_filtered(),
            "data" => $data,
        );
        //output to json format 
        echo json_encode($output);
    }

    //Ajax Edit Training
    public function ajax_editTraining($id_training)
    {
        $this->load->model("trainingModel", "manager", TRUE);
        $data = $this->manager->get_by_id($id_training);
        echo json_encode($data);
    }

    //Ajax Tambah Training
    public function ajax_addTraining()
    {
        $this->load->model("trainingModel", "manager", TRUE);
        $data = array(
            'id_training' => $this->input->post('id_training'),
            'topik' => $this->input->post('topik'),
            'instruktur' => $this->input->post('instruktur'),
            'type' => $this->input->post('type'),
            'tanggal' => $this->input->post('tanggal'),
            'jam' => $this->input->post('jam'),
            'training_delivery' => $this->input->post('training_delivery'),
            'biaya' => $this->input->post('biaya'),
            'Status' => $this->input->post('Status'),
        );
        //Kirim ke model untuk diinput ke DB
        $insert = $this->manager->save($data);
        //Simpan berhasil, kirim notifikasi status=true (berhasil)
        echo json_encode(array("status" => TRUE));
    }

    //Ajax Update Training

    public function ajax_updateTraining()
    {
        $this->load->model("trainingModel", "manager", TRUE);

        $data = array(
            'id_training' => $this->input->post('id_training'),
            //'pegawai' => $this->input->post('pegawai'),
            'topik' => $this->input->post('topik'),
            'instruktur' => $this->input->post('instruktur'),
            'type' => $this->input->post('type'),
            'tanggal' => $this->input->post('tanggal'),
            'jam' => $this->input->post('jam'),
            'training_delivery' => $this->input->post('training_delivery'),
            'biaya' => $this->input->post('biaya'),
            'Status' => $this->input->post('Status'),
        );
        $this->manager->update(array('id_training' => $this->input->post('id_training')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_deleteTraining($id_training)
    {
        $this->load->model("trainingModel", "manager", TRUE);

        $this->manager->delete_by_id($id_training);
        echo json_encode(array("status" => TRUE));
    }


    //Kelola C'Training
    public function kelolaForm()
    {
        $this->load->model("formModel", "manager", TRUE);
        $data['title'] = 'Data Training';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        // $data['trainig'] = $this->db->query("SELECT * FROM training group by id_training")->result_array();

        $data['training'] = $this->db->get('tbl_form')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('manager/KelolaForm', $data);
        $this->load->view('templates/footer', $data);
    }

    //Ajax List Training
    public function ajax_listForm()
    {
        $this->load->model("formModel", "manager", TRUE);
        $list = $this->manager->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $manager) {
            $no++;
            $row = array();
            $row[] = $manager->id_form;
            $row[] = $manager->nama_pegawai;
            $row[] = $manager->register;
            $row[] = $manager->telp;
            $row[] = $manager->softskill;
            $row[] = $manager->techskill;
            $row[] = $manager->keterangan;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" style="margin-bottom:5px;" title="Edit"  onclick="edit_ctraining(' . "'" . $manager->id_form . "'" . ')"><i class="fa fa-edit"></i> Ubah </a>
        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"  onclick="delete_ctraining(' . "'" . $manager->id_form . "'" . ')"><i class="fa fa-trash"></i> Hapus </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->count_all(),
            "recordsFiltered" => $this->manager->count_filtered(),
            "data" => $data,
        );
        //output to json format 
        echo json_encode($output);
    }


    public function ajax_editcTraining($id_form)
    {
        $this->load->model("formModel", "manager", TRUE);
        $data = $this->manager->get_by_id($id_form);
        echo json_encode($data);
    }

    public function ajax_addcTraining()
    {
        $this->load->model("formModel", "manager", TRUE);
        $data = array(
            'id_form' => $this->input->post('id_form'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'register' => $this->input->post('register'),
            'telp' => $this->input->post('telp'),
            'softskill' => $this->input->post('softskill'),
            'techskill' => $this->input->post('techskill'),
            'keterangan' => $this->input->post('keterangan'),
        );
        //Kirim ke model untuk diinput ke DB
        $insert = $this->manager->save($data);
        //Simpan berhasil, kirim notifikasi status=true (berhasil)
        echo json_encode(array("status" => TRUE));
    }

    //Ajax Update Training

    public function ajax_updatecTraining()
    {
        $this->load->model("formModel", "manager", TRUE);

        $data = array(
            'id_form' => $this->input->post('id_form'),
            'nama_pegawai' => $this->input->post('nama_pegawai'),
            'register' => $this->input->post('register'),
            'telp' => $this->input->post('telp'),
            'softskill' => $this->input->post('softskill'),
            'techskill' => $this->input->post('techskill'),
            'keterangan' => $this->input->post('keterangan'),
        );
        $this->manager->update(array('id_form' => $this->input->post('id_form')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_deletecTraining($id_form)
    {
        $this->load->model("formModel", "manager", TRUE);

        $this->manager->delete_by_id($id_form);
        echo json_encode(array("status" => TRUE));
    }

    public function export($user)
    {
        $data = array(
            'title' => 'Laporan Kelola Training',
            'Kelola Training' => $this->trainingModel->getAll()
        );

        $this->load->view('kelolaTraining', $data);
    }

    //export ke dalam format excel
    public function export_excel()
    {
        $data['title'] = 'Lihat Training';
        $data['training'] = $this->db->get('training')->result_array();
        $this->load->view('manager/excel', $data);
    }
}
