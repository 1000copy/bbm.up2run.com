<?header('Content-Type: text/html; charset=utf-8');
  include "../config.inc.php";
?>
<html>
<head>
  <LINK REL="StyleSheet" HREF="../bootstrap/css/bootstrap.min.css" TYPE="text/css" >
      
</head>
<body>
<?

// $html = <<< HTML
// <html>
// <h1>hello1<span>world</span></h1>
// <p>random text</p>
// <h1>title1</h1>
// <h1>title2</h1>
// </html>
// HTML;

// $dom = new DOMDocument;
// $dom->loadHTML($html);
// foreach ($dom->getElementsByTagName('h1') as $node) {
//     // echo $dom->saveHtml($node);
//     echo $node -> nodeValue."<br/>";
// }

?>


<?

  $dom = new DOMDocument;
  $html = "http://book.douban.com/subject_search?search_text=%E7%81%BF%E7%83%82%E5%8D%83%E9%98%B3&cat=1001";
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
        $title = $tag -> getAttribute("href");
        // echo $title."<br/>";
        echo '<li class="span2"><a href="#" class="thumbnail">';
        echo "<img src='{$url}' alt='{$title}'/>";
        echo "</li>";
      }
  }
  echo "</ul>";
?>

