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
    $path = new DOMXPath($dom);
    $tags = $path -> query("//ul[@class='subject-list']/li[@class='subject-item']");
    echo '<ul class="thumbnails">';
    foreach($tags as $v){
      // echo $v -> nodeValue."<br/>";
      $ttt = $path ->query("div/a/img",$v);
      $url = $ttt->item(0)->getAttribute("src");
      $ttt = $path ->query("div/h2/a",$v);
      $title1 = $ttt -> item(0) -> getAttribute("title");
      $href = $ttt -> item(0) -> getAttribute("href");
      echo "<li class='span2'><div href='#' class='thumbnail' align='center'>";
      echo "<img src='{$url}' alt='{$title}' width='90' height='150'/>";
      echo "<input type='radio' name='whichbook' value='{$href}' >{$title1}</input>";
      echo "</div></li>";
    }
    echo "</ul>";
  }
}else {
  echo "selected :".$_POST['whichbook'];
}
?>
<input type="submit" name ="submit" value="select" class="btn-primary"/>
</form>