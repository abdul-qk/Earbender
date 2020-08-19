<?php

class Post extends CI_Controller
{

    public function newPost()
    {
        $post = $this->input->post('post_msg');

        $this->load->model('PostModel');
        $this->PostModel->addPost($post);
        $uname = $this->session->uname;
        $this->load->model('PostModel');
        $postdata = $this->PostModel->showPost($uname);

        $this->load->model('FollowModel');
        $data = $this->FollowModel->recentFollowers();

        $post_data = array(
            'postData' => $postdata,
            'recFollowData' => $data
        );

        $data['title'] = "Earbender";

        $this->load->view('templates/header', $data);
        $this->load->view('pages/home', $post_data);
        $this->load->view('templates/footer');
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

    public function delete()
    {
        $this->load->model('UserModel', 'user');
        $check = $this->user->isLoggedIn();

        if ($check) {

            $uname = $this->session->uname;
            $post = $this->input->post('post_id');

            $data['title'] = 'Earbender - Profile';

            $this->load->model('UserModel', 'user');
            $profile = $this->user->getProfileData($uname);
            $genres = $this->user->getGenres($uname);

            $this->load->model('PostModel', 'post');
            $postdata = $this->post->showUserPost($uname);
            $this->post->delete($post);

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
