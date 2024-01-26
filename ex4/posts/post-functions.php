<?php

include_once 'Post.php';

const DATA_FILE = 'posts.txt';
const ID_FILE = 'next-id.txt';

function savePost(Post $post): string
{
    if (!$post->id) {
        $post->id = getNewId();
    } else {
        deletePostById($post->id);
    }

    file_put_contents(DATA_FILE, getPostAsLine($post), FILE_APPEND);

    return $post->id;
}

function deletePostById(string $id): void
{
    $posts = getAllPosts();
    $posts = array_filter($posts, function (Post $post) use ($id) {
        return $post->id != $id;
    });

    $contents = array_map('getPostAsLine', $posts);
    file_put_contents(DATA_FILE, implode('', $contents));
}

function getPostAsLine(Post $post): string
{
    return implode(';', [
            urlencode($post->id),
            urlencode($post->title),
            urlencode($post->text)
        ]) . PHP_EOL;
}

function getAllPosts(): array
{
    $lines = file(DATA_FILE);

    return array_map(function ($line) {
        [$id, $title, $text] = explode(';', trim($line));
        return new Post(urldecode($id), urldecode($title), urldecode($text));
    }, $lines);
}

function getNewId(): string
{
    $id = intval(file_get_contents(ID_FILE));
    file_put_contents(ID_FILE, $id + 1);
    return (string)$id;
}

function printPosts(array $posts)
{
    foreach ($posts as $post) {
        print $post . PHP_EOL;
    }
}

// Test
$post = new Post(null, 'Title', 'text');
$post->id = savePost($post);
printPosts(getAllPosts());
