<?php

class thread {

    public $id;
    public $title;
    public $posts;
    public $first_post;
    private $settings;
    public $num_replys;
    public $poster;
    public $forum;

    function __construct() {
        $this->settings = new settings ();
    }

    function load($id) {
        mysql::connect();
        $result = mysql_query("
                SELECT * FROM `threads`
                WHERE `id` = '$id'
                ") or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if ($this->settings->debug)
            echo 'Loading thread ' . $id . '...<br /><pre>' . print_r($row, true) . '</pre>';
        $this->id = $row['id'];
        $this->title = $row['title'];
        $this->first_post = $row['first_post'];
        $this->poster = $row['poster'];
        $this->forum = $row['forum'];

        $result = mysql_query("
            SELECT * FROM `posts`
            WHERE `thread` = '$id'
            ");
        while ($row = mysql_fetch_array($result)) {
            $this->posts[$row['id']] = $row['id'];
        }
        $this->num_replys = count($this->posts) - 1;
        if ($this->num_replys < 0)
            $this->num_replys = 0;
        mysql::disconnect();
    }

    function save() {
        $poster = $_SESSION['user']->id;
        mysql::connect();
        mysql_query("
            INSERT INTO `threads`
            (`title`,`poster`,`forum`)
            VALUES
            ('$this->title','$poster','$this->forum')
            ");
        $thread_id = mysql_insert_id();
        $this->id = $thread_id;
        mysql_query("
            INSERT INTO `posts`
            (`title`,`poster`,`thread`)
            VALUES
            ('$this->title','$poster','$thread_id')
            ") or die(mysql_error());
        $post_id = mysql_insert_id();
        $this->first_post = $post_id;
        mysql_query("
            UPDATE `threads`
            SET
            `first_post` = '$post_id'
            WHERE `id` = '$this->id'
            ") or die(mysql_error());
    }

    function getTopicIdArray() {
        $array = array();
        foreach ($this->posts as $post) {
            $array[$post] = $post;
        }
        return $array;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getPosts() {
        return $this->posts;
    }

    public function setPosts($posts) {
        $this->posts = $posts;
    }

    public function getNum_replys() {
        return $this->num_replys;
    }

    public function setNum_replys($num_replys) {
        $this->num_replys = $num_replys;
    }

    public function getPoster() {
        return $this->poster;
    }

    public function setPoster($poster) {
        $this->poster = $poster;
    }

    public function getForum() {
        return $this->forum;
    }

    public function setForum($forum) {
        $this->forum = $forum;
    }

}

?>