<?php

class Search extends CI_Controller
{

    public function autocomplete()
    {

        $term = $this->input->get('term');

        $this->load->model('UserModel');
        $output = $this->UserModel->autoGenre($term);

        echo $output;
    }

    public function searchGenre()
    {

        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $genre = $this->input->post('search_genre');

            $this->load->model('SearchModel');
            $search = $this->SearchModel->searchIt($genre);

            $output['search'] = $search;
            $data['title'] = "Earbender - Search";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/search', $output);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = "Earbender - Landing";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/landing');
            $this->load->view('templates/footer');
        }
    }
}
