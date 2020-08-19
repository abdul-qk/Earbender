<?php

class FollowModel extends CI_Model
{

    function addFollower($uname, $follower)
    {
        $this->load->database();

        $followers = array(
            'username' => $follower,
            'follower' => $uname
        );

        $followings = array(
            'username' => $uname,
            'following' => $follower
        );

        $this->db->insert('user_followers', $followers);
        $this->db->insert('user_followings', $followings);
    }

    function removeFollower($uname, $follower)
    {
        $this->load->database();

        $this->db->where('username', $follower);
        $this->db->where('follower', $uname);
        $this->db->delete('user_followers');

        $this->db->where('username', $uname);
        $this->db->where('following', $follower);
        $this->db->delete('user_followings');
    }

    function viewFollowers($uname)
    {
        $this->load->database();

        $userFollowers = array(
            'user_followers.username' => $uname
        );

        $this->db->select('user_followers.follower as username,fullname,bio');
        $this->db->from('user_followers');
        $this->db->join('user_details', 'user_followers.follower =  user_details.username');
        $this->db->where($userFollowers);
        $query = $this->db->get();
        $resultArray = $query->result_array();

        return $resultArray;
    }

    function viewFollowings($uname)
    {
        $userFollowings = array(
            'user_followings.username' => $uname
        );

        $this->db->select('user_followings.following as username,fullname,bio');
        $this->db->from('user_followings');
        $this->db->join('user_details', 'user_followings.following =  user_details.username');
        $this->db->where($userFollowings);
        $query = $this->db->get();
        $resultArray = $query->result_array();

        return $resultArray;
    }

    function recentFollowers()
    {
        $this->load->database();

        $this->db->select('fullname, username');
        $this->db->from('user_details');
        $this->db->order_by("User_id", "desc");
        $this->db->limit(3);

        $query = $this->db->get();
        $resultArray = $query->result_array();

        return $resultArray;
    }

    function getFollowData($uname)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('username', $uname);
        $res = $this->db->get();

        $count = $res->num_rows();

        return $count;
    }

    function getFollowings($uname)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('user_followings');
        $this->db->where('username', $uname);
        $res = $this->db->get();

        $count = $res->num_rows();

        return $count;
    }

    function getFollowers($uname)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('user_followers');
        $this->db->where('username', $uname);
        $res = $this->db->get();

        $count = $res->num_rows();

        return $count;
    }

    function getAllFollowers($uname)
    {

        $this->load->database();

        $this->db->select('follower');
        $this->db->from('user_followers');
        $this->db->where('username', $uname);
        $query = $this->db->get();
        $resultArray = $query->result_array();

        return $resultArray;
    }

    function getAllFollowings($uname)
    {

        $this->load->database();

        $this->db->select('following');
        $this->db->from('user_followings');
        $this->db->where('username', $uname);
        $query = $this->db->get();
        $resultArray = $query->result_array();

        return $resultArray;
    }

    function getFriends($uname)
    {
        $this->load->database();

        $this->db->select('*');

        $this->db->where('username', $uname);
        $query = $this->db->get('user_details');

        $result = $query->result_array();

        return $result;
    }

    function checkFollower($uname, $follower)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->where('username', $follower);
        $this->db->where('follower', $uname);
        $res = $this->db->get('user_followers');

        if ($res->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
