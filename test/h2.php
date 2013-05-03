<?header('Content-Type: text/html; charset=utf-8');?>
<?

$html = <<< HTML
<html>
<h1>hello1<span>world</span></h1>
<p>random text</p>
<h1>title1</h1>
<h1>title2</h1>
</html>
HTML;

$dom = new DOMDocument;
$dom->loadHTML($html);
foreach ($dom->getElementsByTagName('h1') as $node) {
    // echo $dom->saveHtml($node);
    echo $node -> nodeValue."<br/>";
}

?>


<?

$html = <<< HTML
<html>
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
<ul class="subject-list">
        
        
  
  <li class="subject-item">
    <div class="pic">
      <a class="nbg" href="http://book.douban.com/subject/2143732/" onclick="&quot;moreurl(this,{i:&#39;0&#39;})&quot;" }="">
        <img src="./search.result_files/s2651394.jpg" width="90">
      </a>
    </div>
    <div class="info">
      <h2>
        
  
  <a href="http://book.douban.com/subject/2143732/" title="灿烂千阳" onclick="&quot;moreurl(this,{i:&#39;0&#39;})&quot;">

    灿烂千阳


    

  </a>

      </h2>
      <div class="pub">
        
  
  [美] 卡勒德·胡赛尼 / 李继宏 / 上海人民出版社 / 2007-9 / 28.00元

      </div>


        
  
  <div class="star clearfix">
      <span class="allstar45"></span>
      <span class="rating_nums">8.8</span>

    <span class="pl">
        (32052人评价)
    </span>
  </div>






      <div class="ft">
          
  <div class="collect-info">
  </div>


          
          
  

    <div class="buy-info">

        <a href="http://book.douban.com/subject/2143732/buylinks">
            有售
          20.40 元起
        </a>
    </div>


      </div>

    </div>
  </li>
  

        
        
  
  <li class="subject-item">
    <div class="pic">
      <a class="nbg" href="http://book.douban.com/subject/3013649/" onclick="&quot;moreurl(this,{i:&#39;1&#39;})&quot;" }="">
        <img src="./search.result_files/s2970748.jpg" width="90">
      </a>
    </div>
    <div class="info">
      <h2>
        
  
  <a href="http://book.douban.com/subject/3013649/" title="燦爛千陽" onclick="&quot;moreurl(this,{i:&#39;1&#39;})&quot;">

    燦爛千陽


    

  </a>

      </h2>
      <div class="pub">
        
  
  卡勒德‧胡賽尼 / 李靜宜 / 木馬文化 / 2008-3 / 300元

      </div>


        
  
  <div class="star clearfix">
      <span class="allstar45"></span>
      <span class="rating_nums">9.0</span>

    <span class="pl">
        (251人评价)
    </span>
  </div>






      <div class="ft">
          
  <div class="collect-info">
  </div>


          
          
  

    <div class="buy-info">

        <a href="http://book.douban.com/subject/3013649/buylinks">
            有售
          79.20 元起
        </a>
    </div>


      </div>

    </div>
  </li>
  
</ul>
        
        </body>
</html>
HTML;

$dom = new DOMDocument;
$dom->loadHTML($html);
foreach ($dom->getElementsByTagName('li') as $node) {
    // echo $dom->saveHtml($node);
    echo $node -> nodeValue."<br/>";
}

?>