<?header('Content-Type: text/html; charset=utf-8');
  include "../config.inc.php";
  class DoubanBook{
    public  $title;
    public  $url_douban;
    public  $url_image;
  }
  class DoubanBooks{
    public $book_array = array();
    public function __construct($query_title){
      $douban_search_url = 
        "http://book.douban.com/subject_search?search_text={$query_title}&cat=1001";
      $xpath_item = "//ul[@class='subject-list']/li[@class='subject-item']";
      $xpath_image = "div/a/img";
      $xpath_a = "div/h2/a";
      $dom = new DOMDocument;
      // suppress warning by "@" operator .yeah 
      @$dom->loadHTMLFile($douban_search_url);
      $path = new DOMXPath($dom);
      $tags = $path -> query($xpath_item);
      foreach($tags as $v){
        $b = new DoubanBook;
        $ttt = $path ->query($xpath_image,$v);
        $b-> url_image = $ttt->item(0)->getAttribute("src");
        $ttt = $path ->query($xpath_a,$v);
        $b-> title = $ttt -> item(0) -> getAttribute("title");
        $b-> url_douban = $ttt -> item(0) -> getAttribute("href");
        array_push($this->book_array,$b);
      }
    }
  }
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
  <br/>
<?
$action = $_GET["action"];
$submit = $_POST['submit'];
if ($submit == "search"){
  if ($action=="search"){
    $title = $_POST["title"];
    $bs = new DoubanBooks($title);
    echo '<ul class="thumbnails">';
    foreach ($bs->book_array as $v) { ?>
    <li class='span2'>
      <div href='#' class='thumbnail' align='center'>
        <img src='<?echo $v->url_image;?>' alt='<?echo $v->title;?>' width='90' height='150'/>
        <input type='radio' name='whichbook' value='<?echo $v->url_douban;?>' ><?echo $v->title;?></input>
      </div>
    </li>
    <?
    }
    echo "</ul>";
  }
}else {
  echo "selected :".$_POST['whichbook'];
}
?>
<p>
<input type="submit" name ="submit" value="select" class="btn-primary"/>
</form>
