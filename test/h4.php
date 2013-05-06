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
  <input type="submit" name ="submit" value="search" class="btn-primary"/>
<?
$action = $_GET["action"];
$submit = $_POST['submit'];
if ($submit == "search"){
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
    echo '<ul class="thumbnails">';
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
          $href = $tag -> getAttribute("href");
          // echo $title."<br/>";
          echo '<li class="span2"><div href="#" class="thumbnail" align="center">';
          echo "<img src='{$url}' alt='{$title}' width='90' height='150'/>";
          echo "<input type='radio' name='whichbook' value='{$href}' >{$title}</input>";
          echo "</div></li>";
        }
    }
    echo "</ul>";
  }
}else {
  echo "selected :".$_POST['whichbook'];
}
?>
<input type="submit" name ="submit" value="select" class="btn-primary"/>
</form>