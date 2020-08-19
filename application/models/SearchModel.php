<?php

class SearchModel extends CI_Model
{
    public function searchIt($genre)
    {

        $this->load->database();

        $this->db->select('*');
        $this->db->from('user_genre');
        $this->db->join('user_details', 'user_genre.username = user_details.username');
        $this->db->like('genre_name', $genre);
        $this->db->group_by('user_details.username');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }
}
