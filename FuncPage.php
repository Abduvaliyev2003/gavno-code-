<?php

function setHomePage($chat_id, $page) {
    $filename = 'page/' . $chat_id . 'home.txt';
    file_put_contents($filename , $page);
}

function getHomePage($chat_id){
    return  file_get_contents('page/' . $chat_id . 'home.txt');
}

function setCommentPage($chat_id, $page) {
    $filename = 'page/' . $chat_id . 'home.txt';
    file_put_contents($filename , $page);
}

function getCommentPage($chat_id){
    return  file_get_contents('page/' . $chat_id . 'comment.txt');
}
?>