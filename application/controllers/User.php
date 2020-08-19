<?php

class User extends CI_Controller
{

    public function registerFinal()
    {
        $image = $this->input->post('baseImageString');
        $bio = $this->input->post('bio');
        $genre = $this->input->post('genre');

        $this->load->model('UserModel', 'user');

        $tempUser = $this->session->userdata('tempUser');

        if (isset($tempUser)) {

            $this->user->registerSecond($image, $bio, $genre, $tempUser);

            $data['title'] = 'Earbender - Login';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/login');
            $this->load->view('templates/footer');
        } else {

            $error['msg'] = "Session invalid. Please try again!";
            
            $data['title'] = 'Earbender - Login';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/signup', $error);
            $this->load->view('templates/footer');
        }
    }

    public function signup()
    {
        $name = $this->input->post('name');
        $uname = $this->input->post('uname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $pwd = $this->input->post('pswd');

        $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);

        $this->load->model('UserModel', 'user');
        $genres = $this->user->getAllGenres();
        $msg = $this->user->addUser($name, $uname, $email, $phone, $pwdHash);

        if ($msg == 'success') {

            $data['title'] = 'Earbender - Final Touches';

            $output['genres'] = $genres;

            $this->load->view('templates/header', $data);
            $this->load->view('pages/final_info', $output);
            $this->load->view('templates/footer');
        } else {


            $data['title'] = 'Earbender - Register';
            $error['msg'] = $msg;

            $this->load->view('templates/header', $data);
            $this->load->view('pages/signup', $error);
            $this->load->view('templates/footer');
        }
    }

    public function login()
    {
        $uname = $this->input->post('uname');
        $pwd = $this->input->post('pswd');

        $this->load->model('UserModel', 'user');
        $verify = $this->user->verifyUser($uname, $pwd);

        if ($verify == "Success") {

            $data['title'] = 'Earbender';

            $this->session->set_userdata('uname', $uname);
            $this->load->model('PostModel');
            $postdata = $this->PostModel->showPost($uname);

            $this->load->model('FollowModel');
            $data_rec = $this->FollowModel->recentFollowers();

            $post_data = array(
                'postData' => $postdata,
                'recFollowData' => $data_rec
            );

            $this->load->view('templates/header', $data);
            $this->load->view('pages/home', $post_data);
            $this->load->view('templates/footer');
        } else {

            $data['title'] = 'Earbender - Login';

            $error['msg'] = $verify;

            $this->load->view('templates/header', $data);
            $this->load->view('pages/login', $error);
            $this->load->view('templates/footer');
        }
    }

    public function viewEditProfile()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $data['title'] = 'Earbender - Edit Profile';
            $uname = $this->session->uname;

            $this->load->model('UserModel');
            $profile = $this->UserModel->getProfileData($uname);
            $allGenres = $this->UserModel->getAllGenres();
            $genres = $this->UserModel->getGenresNameArr($uname);
            $output = array(
                'profile' => $profile,
                'allGenres' => $allGenres,
                'genres' => $genres,
            );
            // $output['profile'] = $profile;

            $this->load->view('templates/header', $data);
            $this->load->view('pages/edit_profile', $output);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = "Earbender - Landing";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/landing');
            $this->load->view('templates/footer');
        }
    }

    public function showFriends($uname)
    {

        $this->load->model('FollowModel', 'follow');
        $follower = $this->follow->getAllFollowers($uname);
        $following = $this->follow->getAllFollowings($uname);

        $followerArray = array();
        $followingArray = array();

        foreach ($follower as $oneFollower) {
            array_push($followerArray, $oneFollower['follower']);
        }

        foreach ($following as $oneFollowing) {
            array_push($followingArray, $oneFollowing['following']);
        }

        $friends = array_intersect($followerArray, $followingArray);

        $finalFriends = $this->formatFriends($friends);

        return $finalFriends;
    }

    public function formatFriends($friendNames)
    {

        $friendArray = array();

        foreach ($friendNames as $friend) {

            $this->load->model('FollowModel', 'follow');
            $friendsData = $this->follow->getFriends($friend);

            array_push($friendArray, $friendsData);
        }

        return $friendArray;
    }

    public function editProfile()
    {
        $name = $this->input->post('name_edit');
        $bio = $this->input->post('bio_edit');
        $phone = $this->input->post('phone_edit');
        $avatar = $this->input->post('baseImageString');
        $email = $this->input->post('email_edit');
        $address = $this->input->post('address_edit');
        $genre = $this->input->post('genre');
        $uname = $this->session->uname;

        $this->load->model('UserModel', 'user');
        $this->user->modifyProfile($uname, $name, $bio, $phone, $avatar, $email, $address, $genre);

        $check = $this->user->isLoggedIn();

        if ($check) {

            $data['title'] = 'Profile';

            $this->load->model('UserModel', 'user');
            $profile = $this->user->getProfileData($uname);
            $genres = $this->user->getGenres($uname);

            $this->load->model('PostModel');
            $postdata = $this->PostModel->showUserPost($uname);

            $this->load->model('FollowModel', 'follow');
            $user_followers = $this->follow->viewFollowers($uname);
            $user_followings = $this->follow->viewFollowings($uname);
            $follow = $this->follow->getFollowData($uname);
            $followers = $this->follow->getFollowers($uname);
            $followings = $this->follow->getFollowings($uname);
            $friends = $this->showFriends($uname);

            $output = array(
                'profile' => $profile,
                'follow' => $follow,
                'followers' => $followers,
                'followings' => $followings,
                'postData' => $postdata,
                'user_followers' => $user_followers,
                'user_followings' => $user_followings,
                'friends' => $friends,
                'genres' => $genres,
            );

            $this->load->view('templates/header', $data);
            $this->load->view('pages/profile', $output);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = "Earbender - Landing";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/landing');
            $this->load->view('templates/footer');
        }
    }
}
