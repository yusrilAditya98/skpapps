<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Model_kemahasiswaan extends CI_Model
{

    public function insertPoinSkp($data)
    {
        $this->db->insert_batch('poin_skp', $data);
    }
}
