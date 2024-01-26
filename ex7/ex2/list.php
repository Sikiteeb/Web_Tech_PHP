<?php

require_once 'Book.php';
require_once 'Author.php';
require_once '../vendor/tpl.php';

$books = [['Head First HTML and CSS', [['Elisabeth', 'Robson'], ['Eric', 'Freeman']], 5],
    ['Learning Web Design', [['Jennifer', 'Robbins']], 4],
    ['Head First Learn to Code', [['Eric', 'Freeman']], 4]];

$book = new Book('Head First HTML and CSS', 5, false);
$book->addAuthor(new Author('Elisabeth', 'Robson'));
$book->addAuthor(new Author('Eric', 'Freeman'));

$book2 = new Book('Learning Web Design', 4, false);
$book2->addAuthor(new Author('Jennifer', 'Robbins'));

$data = [
    'books' => [$book, $book2],
    'contentPath' => 'list.html'

];

print renderTemplate('tpl/main2.html', $data);