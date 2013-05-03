<?

$html = <<< HTML
<html>
<h1>hello1<span>world</span></h1>
<p>random text</p>
<h1>title1</h1>
<h1>title2</h1>
</html>
HTML;

$reader = new XMLReader;
$reader->xml($html);
while($reader->read() !== FALSE) {
    if($reader->name === 'h1' && $reader->nodeType === XMLReader::ELEMENT) {
        echo $reader->readString()."<br>";
    }
}

?>