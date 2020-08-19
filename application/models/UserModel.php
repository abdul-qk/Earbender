<?php

class UserModel extends CI_Model
{

    function addUser($name, $uname, $email, $phone, $password)
    {
        $this->load->database();

        $emailAvailability = $this->db->where('email', $email)->count_all_results('user_details');
        $userAvailability = $this->db->where('username', $uname)->count_all_results('user_details');

        if ($userAvailability == 0) {

            if ($emailAvailability == 0) {
                $user = array(
                    'username' => $uname,
                    'fullname' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $password
                );
                $this->session->set_userdata('tempUser', $user);

                //$this->db->insert('user_details', $user);
                return 'success';
            } else {
                return 'Email is already taken.';
            }
        } else {
            return 'Username is already taken.';
        }
    }

    function verifyUser($uname, $password)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('username', $uname);
        $this->db->limit(1);
        $res = $this->db->get();

        if ($res->num_rows() == 1) {

            foreach ($res->result() as $row) {
                $pswdHashed = $row->passsword;
            }

            if (password_verify($password, $pswdHashed)) {
                $msg = "Success";
            } else {
                $msg = "Password is wrong!";
            }
        } else {
            $msg = "Username is Incorrect!";
        }

        return $msg;
    }

    function isLoggedIn()
    {
        if (isset($this->session->uname)) {
            return true;
        } else {
            return false;
        }
    }

    function registerSecond($image, $bio, $genres, $temp)
    {
        $this->load->database();

        $resultGenre = array();

        for ($x = 0; $x < count($genres); $x++) {
            $genre = array(
                'genre_name' => $genres[$x],
                'username' => $temp['username'],
            );
            array_push($resultGenre, $genre);
        }

        $user = array(
            'username' => $temp['username'],
            'fullname' => $temp['fullname'],
            'email' => $temp['email'],
            'phone' => $temp['phone'],
            'passsword' => $temp['password'],
            'avatar' => $image,
            'bio' => $bio
        );

        $this->db->insert('user_details', $user);
        $this->db->insert_batch('user_genre', $resultGenre);
        session_destroy();
    }

    function getProfileData($uname)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('username', $uname);
        $res = $this->db->get();

        foreach ($res->result() as $row) {

            $res_array = array(
                'uname' => $row->username,
                'name' => $row->fullname,
                'bio' => $row->bio,
                'avatar' => $row->avatar,
                'phone' => $row->phone,
                'email' => $row->email,
                'address' => $row->address,
            );
        }

        return $res_array;
    }

    public function modifyProfile($uname, $name, $bio, $phone, $avatar, $email, $address, $genres)
    {
        $this->load->database();
        $resultGenre = array();

        for ($x = 0; $x < count($genres); $x++) {
            $genre = array(
                'genre_name' => $genres[$x],
                'username' => $uname,
            );
            array_push($resultGenre, $genre);
        }

        $data = array(
            'fullname' => $name,
            'bio' => $bio,
            'phone' => $phone,
            'avatar' => $avatar,
            'email' => $email,
            'address' => $address,
        );
        $this->db->where('username', $uname);
        $this->db->update('user_details', $data);
        $this->db->where_in('username', $uname);
        $this->db->delete('user_genre');
        $this->db->insert_batch('user_genre', $resultGenre);

        return true;
    }

    public function autoGenre($term)
    {
        $this->load->database();

        $this->db->like('genre_name', $term);
        $res = $this->db->get("genre")->result();

        return json_encode($res);
    }

    public function getGenres($uname)
    {
        $this->load->database();

        $this->db->select('genre_name');
        $this->db->where('username', $uname);
        $res = $this->db->get('user_genre');

        $result = $res->result_array();

        return $result;
    }

    public function getGenresNameArr($uname)
    {
        $genreName = array();
        $this->load->database();
        $this->db->select('genre_name');
        $this->db->where('username', $uname);
        $res = $this->db->get('user_genre');
        $results = $res->result_array();

        foreach ($results as $result) {
            array_push($genreName, $result['genre_name']);
        }

        return $genreName;
    }

    public function getAllGenres()
    {
        $this->load->database();

        $this->db->select('genre_name');
        $query = $this->db->get('genre');
        $res = $query->result_array();

        return $res;
    }
}
