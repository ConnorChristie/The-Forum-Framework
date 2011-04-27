<?php

class post {

    public $id;
    public $timestamp;
    public $text;
    public $title;
    public $poster;
    public $thread;
    public $colour;
    private $settings;

    function __construct() {
        $this->settings = new settings ();
    }

    function load($id) {
        mysql::connect();
        $result = mysql_query("
                SELECT * FROM `posts`
                WHERE `id` = '$id'
                ORDER BY `id` ASC
                LIMIT 10
                ") or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if ($this->settings->debug)
            echo 'Loading post ' . $id . '...<br /><pre>' . print_r($row, true) . '</pre>';
        mysql::disconnect();
        $this->id = $row['id'];
        $this->timestamp = $row['timestamp'];
        $this->text = $row['text'];
        $this->title = $row['title'];
        $this->poster = $row['poster'];
        $this->thread = $row['thread'];
        $this->colour = $row['colour'];
    }

    function save() {
        mysql::connect();
        mysql_query("
            INSERT INTO `posts`
            (`timestamp`,`text`,`title`,`poster`,`thread`,`colour`)
            VALUES
            ('$this->timestamp','$this->text', '$this->title', '$this->poster', '$this->thread','$this->colour')
            ") or die(mysql_error());
        mysql::disconnect();
    }

    function update() {
        mysql::connect();
        mysql_query("
            UPDATE `posts`
            SET
                `text` = '$this->text',
                `title` = '$this->title',
                `colour` = '$this->colour'
            WHERE `id` = '$this->id'
            ") or die(mysql_error());
        mysql::disconnect();
    }

    public function getColour() {
        return $this->colour;
    }

    public function setColour($colour) {
        $this->colour = $colour;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getPoster() {
        return $this->poster;
    }

    public function setPoster($poster) {
        $this->poster = $poster;
    }

    public function getThread() {
        return $this->thread;
    }

    public function setThread($thread) {
        $this->thread = $thread;
    }

}

?>
