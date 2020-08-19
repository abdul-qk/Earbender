<?php

class Earbender extends CI_Controller
{

    public function home()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $uname = $this->session->uname;

            $this->load->model('PostModel');
            $postdata = $this->PostModel->showPost($uname);

            $this->load->model('FollowModel');
            $data_rec = $this->FollowModel->recentFollowers();

            $post_data = array(
                'postData' => $postdata,
                'recFollowData' => $data_rec
            );

            $data['title'] = 'Earbender';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/home', $post_data);
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

    public function profile()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $uname = $this->session->uname;

            $data['title'] = 'Earbender - Profile';

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

    public function logout()
    {
        $this->session->sess_destroy();

        $data['title'] = "Earbender - Landing";

        redirect('/landing');
    }

    public function publicProfile()
    {

        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $uname = $this->input->post('username_public');
            $current_user = $this->session->uname;

            $data['title'] = 'Earbender - Public Profile';

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
            $checkFollow = $this->follow->checkFollower($current_user, $uname);

            $output = array(
                'profile' => $profile,
                'follow' => $follow,
                'followers' => $followers,
                'followings' => $followings,
                'postData' => $postdata,
                'user_followers' => $user_followers,
                'user_followings' => $user_followings,
                'check' => $checkFollow,
                'genres' => $genres,
            );

            $this->load->view('templates/header', $data);
            $this->load->view('pages/public_profile', $output);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = "Earbender - Landing";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/landing');
            $this->load->view('templates/footer');
        }
    }

    public function contact()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();
        $data['title'] = "Earbender - Contact";

        if ($check) {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/contact');
            $this->load->view('templates/footer');
        } else {
            $data['title'] = "Earbender - Landing";

            $this->load->view('templates/header', $data);
            $this->load->view('pages/landing');
            $this->load->view('templates/footer');
        }
    }
}
