<?php

class Follow extends CI_Controller
{

    public function showFollower()
    {

        $this->load->model('FollowModel');
        $dataFollower = $this->FollowModel->viewFollowers();
        $follower_data = array(
            'followerData' => $dataFollower
        );

        $data = "Follower";

        $this->load->view('templates/header', $data);
        $this->load->view('pages/followers', $follower_data);
        $this->load->view('templates/footer');
    }

    public function showFollowing()
    {

        $this->load->model('FollowModel');
        $data = $this->FollowModel->viewFollowing();

        $followings_data = array(
            'followingData' => $data
        );

        $data = "Following";

        $this->load->view('templates/header', $data);
        $this->load->view('pages/following', $followings_data);
        $this->load->view('templates/footer');
    }

    public function recentFollowers()
    {
        $this->load->model('FollowModel');
        $data = $this->FollowModel->recentFollowers();

        $recentFollow = array(
            'recFollowData' => $data
        );

        $this->load->view('templates/header', $data);
        $this->load->view('pages/home', $recentFollow);
        $this->load->view('templates/footer');
    }

    public function addFollower()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $uname = $this->input->post('follower');
            $current_user = $this->session->uname;

            $data['title'] = 'Earbender - Public Profile';

            $this->load->model('UserModel', 'user');
            $profile = $this->user->getProfileData($uname);
            $genres = $this->user->getGenres($uname);

            $this->load->model('PostModel');
            $postdata = $this->PostModel->showUserPost($uname);

            $this->load->model('FollowModel', 'follow');
            $this->follow->addFollower($current_user, $uname);
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

    public function removeFollower()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $uname = $this->input->post('unfollow');
            $current_user = $this->session->uname;

            $data['title'] = 'Earbender - Public Profile';

            $this->load->model('UserModel', 'user');
            $profile = $this->user->getProfileData($uname);
            $genres = $this->user->getGenres($uname);

            $this->load->model('PostModel');
            $postdata = $this->PostModel->showUserPost($uname);

            $this->load->model('FollowModel', 'follow');
            $this->follow->removeFollower($current_user, $uname);
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
}
