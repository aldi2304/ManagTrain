<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pegawaiModel extends CI_Model
{
    private $tablePegawai = "tbl_karyawan";

    var $table = "tbl_karyawan";
    var $column_order = array('id_pegawai', 'nama', 'grade', 'cluster', 'dept', 'sub_dept', 'Status', 'gender', 'jabatan', 'dob', 'doj', null); //set column field database for datatable orderable
    var $column_search = array('id_pegawai', 'nama', 'dept', 'sub_dept', 'jabatan',); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_pegawai' => 'asc'); // default order 

    function getPegawai()
    {
        return $this->db->get("tbl_karyawan");
    }
    function getPegawaiById($id_pegawai)
    {
        $this->db->where("id_pegawai", $id_pegawai);
        return $this->db->get('tbl_karyawan');
    }

    function getTrainingById($id_training)
    {
        $this->db->where("id_training", $id_training);
        return $this->db->get('training');
    }


    public function getAll()
    {
        return $this->db->get($this->tablePegawai)->result();
    }

    function saveDataPegawai($data)
    {
        return $this->db->insert($this->tablePegawai, $data);
    }

    function updateDataPegawai($data, $id_pegawai)
    {
        return $this->db->update($this->tablePegawai, $data, array('id_pegawai' => $id_pegawai));
    }

    function deleteDataPegawai($id_pegawai)
    {
        return $this->db->delete($this->tablePegawai, array('id_pegawai' => $id_pegawai));
    }
    function updateDataTraining($data, $id_training)
    {
        return $this->db->update($this->tableTraining, $data, array('id_training' => $id_training));
    }

    function deleteDataTraining($id_training)
    {
        return $this->db->delete($this->tableTraining, array('id_training' => $id_training));
    }



    //Untuk Ajax
    private function _get_datatables_query()
    {

        $this->db->from($this->tablePegawai);

        $i = 0;


        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->tablePegawai);
        return $this->db->count_all_results();
    }

    public function get_by_id($id_pegawai)
    {
        $this->db->from($this->tablePegawai);
        $this->db->where('id_pegawai', $id_pegawai);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->tablePegawai, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->tablePegawai, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id_pegawai)
    {
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->delete($this->tablePegawai);
    }

    public function cekKodePegawai()
    {
        $query = $this->db->query("SELECT MAX(id_pegawai) as idpegawai from tbl_karyawan");
        $hasil = $query->row();
        return $hasil->idpegawai;
    }
}
