<?php
ob_start();
const monthTable = array('NULL', 'January', 'Feburary', 'March', 'April', 'May', 'June', 'July', "August", 'September', 'October', 'November', 'December');
foreach (scandir("_posts/", SCANDIR_SORT_DESCENDING) as $post) {
  if($post == '.' || $post == '..') continue;
  $location = $post;
  $post = str_replace('_posts/', '', $post);
  $location = $post;
  $postDate = substr($post, 0, 11);
  $postName = str_replace($postDate,'', $post);
  $postName = str_replace('-',' ', $postName);
  $postName = str_replace('.md', '', $postName);
  $postMonth = substr($postDate, 5,2);
  $postMonth = monthTable[str_replace('0','',$postMonth)];
  $postDay = str_replace('0', '', substr($postDate, 8,2));
  $postYear = substr($postDate, 0, 4);
  $postDate = $postMonth .' '. $postDay .', '. $postYear;
  $postName = ucwords($postName);
  echo("<span class='post-meta'>".$postDate."</span><h3><a class='post-link' href='?post=".$location."'>".$postName."</a></h3>");
}
if(isset($_GET['post']))
{
  ob_clean();
  include($_SERVER['DOCUMENT_ROOT'].'/global/pkgs/Parsedown.php');
  $selectedPost = $_GET['post'];
  $selectedPost = file_get_contents('_posts/'.$selectedPost);
  $selectedPost = explode('-', $selectedPost);
  $postSettings = array_slice($selectedPost, 0, 6);
  $postContent = array_slice($selectedPost, 6, sizeof($selectedPost));
  $postSettings = implode(' ', $postSettings);
  $postSettings = str_replace('-',"",$postSettings);
  $postSettings = str_replace('layout: post',"",$postSettings);
  $postSettings = str_replace('title: ',"",$postSettings);
  $postSettings = str_replace('"',"",$postSettings);
  $postContent = implode(' ', $postContent);
  $post = $_GET['post'];
  $postDate = substr($post, 0, 11);
  $postMonth = substr($postDate, 5,2);
  $postMonth = monthTable[str_replace('0','',$postMonth)];
  $postDay = str_replace('0', '', substr($postDate, 8,2));
  $postYear = substr($postDate, 0, 4);
  $postDate = $postMonth .' '. $postDay .', '. $postYear;
  $postContent = '<h1 class="post-title p-name" itemprop="name headline">'.$postSettings.'</h1>'.'<p class="post-meta"><time class="dt-published" itemprop="datePublished">'.$postDate .'</time></p>'. $postContent;
  echo Parsedown::instance()->text($postContent);
}
?>