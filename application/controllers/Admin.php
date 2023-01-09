<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $data['title'] = 'Dashboard Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data2 = $this->searchModel->ambil_data($keyword);
        $data2 = array(
            'keyword'    => $keyword,
            'data2'        => $data2
        );

        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Admin';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data2);
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
        $this->load->view('admin/kelolaPegawai', $data);
        $this->load->view('templates/footer', $data);
    }

    public function lihatPegawai()
    {
        $this->load->helper('url');
        $data['title'] = 'Daftar Pegawai';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->db->from('tbl_karyawan');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data2 = $this->searchModel->ambil_data($keyword);
        $data2 = array(
            'keyword'    => $keyword,
            'data2'        => $data2
        );

        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Admin';

        $data['karyawan'] = $this->db->get('tbl_karyawan')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/lihatPegawai', $data2);
        $this->load->view('templates/footer', $data);
    }

    //Ajax List Pegawai
    public function ajax_listPegawai()
    {

        $list = $this->admin->get_datatables();

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['karyawan'] = $this->db->get_where('tbl_karyawan', ['nama_karyawan' =>
        $this->session->userdata('nama_pegawai')])->result_array();

        $data['jabatan'] = $this->db->get('tbl_jabatan')->result_array();
        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Admin';


        $no = $_POST['start'];
    }

    public function lihatTraining()
    {
        $this->load->helper('url');
        $data['title'] = 'Lihat Training';

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('searchModel');
        $keyword = $this->input->get('keyword');
        $data2 = $this->searchModel->ambil_data2($keyword);
        $data2 = array(
            'keyword'    => $keyword,
            'data2'        => $data2
        );

        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Admin';

        $data['training'] = $this->db->get('training')->result_array();

        $this->db->from('training');
        $config['total_rows'] = $this->db->count_all_results();
        $data['total_rows'] = $config['total_rows'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/lihatTraining', $data);
        $this->load->view('templates/footer', $data);
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer',);
    }
    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->db->where('id ! =', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer',);
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];


        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akses berhasil diubah!</div>');
    }

    public function ubahPassword()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');


        //echo 'Selamat Datang ' . $data['user']['nama_pegawai'] . ' di Halaman Admin';

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/ubahpassword', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password yang anda masukan salah!</div>');
                redirect('admin/ubahpassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password tidak boleh sama!</div>');
                    redirect('admin/ubahpassword');
                } else {
                    // Password sudah benar
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password berhasil diubah!</div>');
                    redirect('admin/ubahpassword');
                }
            }
        }
    }
}
