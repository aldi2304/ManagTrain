<?php
defined('BASEPATH') or exit('No direct script access allowed');

class searchModel extends CI_Model
{
    public function ambil_data($keyword = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_karyawan');
        if (!empty($keyword)) {
            $this->db->like('id_pegawai', $keyword);
        }
        return $this->db->get()->result_array();
    }

    public function ambil_data2($keyword = null)
    {
        $this->db->select('*');
        $this->db->from('training');
        if (!empty($keyword)) {
            $this->db->like('id_training', $keyword);
        }
        return $this->db->get()->result_array();
    }
}
