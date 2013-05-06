<?php
  print '<pre>';
  $html = "
  <table>
<tr>
  <td bgcolor='#CCCCCC' valign='top'><a href='#' class='details'>Indigo Blue 123</a></td>
  <td bgcolor='#CCCCCC'>0</td>
  <td bgcolor='#CCCCCC' align='top'><font class='details'>123 Blue House</font></td>
  <td bgcolor='#CCCCCC'>1</td>
  <td bgcolor='#CCCCCC' valign='top'>2</td>
  <td bgcolor='#CCCCCC'>3</td>

</tr>
</table>
  ";

  // Create new DOM object:
  $dom = new DomDocument();

  // Load HTML code:
  $dom->loadHTML($html);

  $xpath = new DOMXPath($dom);
  $details = $xpath->query("//tr/td[font/@class = 'details']");

  for ($i = 0; $i < $details->length; $i++) {
    echo $details->item($i)->nodeValue;
    // echo $data[$i]['data'];
  }
  print '</pre>';
?>