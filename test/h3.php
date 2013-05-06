<?header('Content-Type: text/html; charset=utf-8');
  include "../config.inc.php";
?>
<html>
<head>
  <LINK REL="StyleSheet" HREF="../bootstrap/css/bootstrap.min.css" TYPE="text/css" >      
</head>
<body>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=search"  method="post" class="form-inline">
  <input type="text" placeholder="some book title..." id="title" name="title" 
  value="<?echo $_POST["title"]; ?>" class="search-query input-medium"/>
  <input type="submit" value="search" class="btn-primary"/>
</form>

<?
$action = $_GET["action"];
if ($action=="search"){
  $title = $_POST["title"];
  $dom = new DOMDocument;
  $html = "http://book.douban.com/subject_search?search_text={$title}&cat=1001";
  // suppress warning by "@" operator .yeah 
  @$dom->loadHTMLFile($html);
  // echo $dom -> documentElement -> tagName;
  $tags = $dom->getElementsByTagName('ul');
  foreach($tags as $ul){
    if ($ul -> getAttribute("class") == "subject-list")
      break;
  }
  foreach ($ul->getElementsByTagName('li') as $node) {
      // echo $dom->saveHtml($node);
      // echo $node -> nodeValue."<br/>";
      $class = $node -> getAttribute("class");
      if ($class=="subject-item");
      {
        // echo "url :"; //= getByPath div / a / img
        $tags  = $node -> getElementsByTagName("div");
        $tag  =$tags->item(0);
        $tags = $tag ->getElementsByTagName("a");
        $tag = $tags -> item(0);
        $tags = $tag -> getElementsByTagName("img");
        $tag = $tags -> item(0);
        $url = $tag -> getAttribute("src");
        // echo $url."<br/>";
        // or ...
        // echo "title :";
        $tags  = $node -> getElementsByTagName("div");
        $tag  =$tags->item(1);
        // echo $tag -> getAttribute("class");
        $tags = $tag ->getElementsByTagName("h2");
        $tag = $tags -> item(0);
        $tags = $tag -> getElementsByTagName("a");
        $tag = $tags -> item(0);
        $title = $tag -> getAttribute("title");
        // echo $title."<br/>";
        $title = $tag -> getAttribute("href");
        // echo $title."<br/>";
        echo "<img src='{$url}' alt='{$title}'/>";
      }
  }
}
?>
