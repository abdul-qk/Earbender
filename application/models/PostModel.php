<?php

class PostModel extends CI_Model
{

    function addPost($post)
    {
        $this->load->database();

        $uname = $this->session->userdata('uname');

        $reg_exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+(\.[a-zA-Z]{2,3})?(\/[A-Za-z0-9-._~!$&()*+,;=:]*)*/";
        $urls = array();
        $u2r = array();
        if (preg_match_all($reg_exUrl, $post, $urls)) {
            foreach ($urls[0] as $url) {
                if (!in_array($url, $u2r)) {
                    $u2r[] = $url;
                }
            }
            foreach ($u2r as $u) {
                $ext = substr($u, strrpos($u, '.'));
                if (in_array($ext, array('.png', '.jpg', '.jpeg', '.gif'))) {
                    $post = str_replace($u, "<img src='" . $u . "' class='img-fluid'><br>", $post);
                } else {
                    $post = str_replace($u, "<a href='" . $u . "' target='_blank'>" . $u . "</a>", $post);
                }
            }

            $post_array = array(
                'username' => $uname,
                'message' => $post
            );
        } else {
            $post_array = array(
                'username' => $uname,
                'message' => $post
            );
        }

        $this->db->insert('posts', $post_array);
    }

    function showPost($uname)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('posts');
        $this->db->join('user_details', 'posts.username = user_details.username ');
        $this->db->join('user_followings', 'user_details.username = user_followings.following ');
        $this->db->where('user_followings.username', $uname);
        $this->db->order_by('posts.created_date', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        $userPosts = $this->showUserPost($uname);
        $userandFollowing = array_merge($result, $userPosts);

        usort($userandFollowing, function ($firstPost, $secondPost) {
            $firstPost = new DateTime($firstPost['created_date']);
            $secondPost = new DateTime($secondPost['created_date']);

            if ($firstPost == $secondPost) {
                return 0;
            }

            return $firstPost > $secondPost ? -1 : 1;
        });

        return $userandFollowing;
    }

    function showUserPost($uname)
    {
        $this->load->database();

        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->join('posts', 'posts.username = user_details.username');
        $this->db->where('user_details.username', $uname);

        $query = $this->db->get();
        $resultArray = array_reverse($query->result_array());

        return $resultArray;
    }

    function delete($post_id)
    {
        $this->load->database();
        $this->db->where('post_id', $post_id);
        $this->db->delete('posts');
    }
}
