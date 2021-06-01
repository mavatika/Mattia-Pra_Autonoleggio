<?php
class Template {
  const REGEX = '/\{(.*?)\}/';
  
  private $page = '';
  
  public function __construct(string $file_needed, $isStatic = true, bool $shouldCalluseStatic = true) {
    if(empty($file_needed)) throw new Exception("File Needed", 1);

    $this->page = self::getFileContent('src/pages', $file_needed, 'html');
    $matches = $this->getPlaceholdersArray();

    foreach ($matches as $str) {
      $cmp = trim($str, '{} ');
      if ($cmp == 'cookie_banner' && !empty($_COOKIE['cookie_banner'])) $this->page = str_replace($str, '', $this->page);
      else if ($cmp == 'common_head') $this->page = str_replace($str, self::commonHead() , $this->page);
      else {
        $component = @include($_SERVER['DOCUMENT_ROOT'].'/src/components/'.$cmp.'.php');
        if (isset($component['template'])) $this->page = str_replace($str, $component['template'], $this->page);
        if (isset($component['head'])) $this->writeHeader($component['head']);
      }
    }

    if ($shouldCalluseStatic) $this->useStatic($isStatic);
  }

  public function useStatic($isStatic) {
    $offset = 0;
    $txt = $this->page;
    $pageLenght = strlen($this->page);
    while ($offset < $pageLenght) {
      $txt = substr($txt, $offset);
      $alternative = self::getTextBetweenTags($txt, 'alternative');
      if (empty($alternative)) break;
      $offset += (strpos($this->page, '<alternative>', $offset) + strlen($alternative) + strlen('<alternative></alternative>'));
      
      $inner = self::getTextBetweenTags($alternative, $isStatic ? 'static' : 'dynamic');
      $this->page = str_replace("<alternative>$alternative</alternative>", $inner, $this->page);
    }
  }

  public function putDynamicContent(array $d) {
    $matches = self::getPlaceholdersArray($this->page);

    foreach ($matches as $str) {
      $index = trim($str, '{} ');
      if (isset($d[$index])) $this->page = str_replace($str, $d[$index], $this->page);
    }

  }

  public function resetPage() {
    $this->page = '';
  }

  public function render() {
    echo $this->page;
  }

  public static function getFileContent(string $dir, string $file, string $ext) {
      return @file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $dir . '/' . $file . '.' . $ext);
  }
  private function getPlaceholdersArray() {
    preg_match_all(self::REGEX, $this->page, $matches);
    return $matches = $matches[0];
  }
  private function getTextBetweenTags(string $all, string $tag) {
    $open = '<' . $tag . '>';
    $close = '</' . $tag . '>';
    $start = strpos($all, $open);
    $start = $start += strlen($open);

    if ($start >= strlen($all)) return '';
    $length = strpos($all, $close, $start) - $start;
    if ($length <= 0) return '';
    return substr($all, $start, $length);
  }

  private function writeHeader(string $heads) {
    $offset = strpos($this->page, '</head>');
    $this->page = substr($this->page, 0, $offset) . $heads . substr($this->page, $offset);
  }

  private static function commonHead() {
    $deepness = str_repeat('../', Utils::getRequestDeepness());
    return '
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="'.$deepness.'css/common.css">
      <link rel="shortcut icon" sizes="16x16" href="'.$deepness.'img/favicon.ico">
      <script defer src="'.$deepness.'js/polyfill.js"></script>
      <script src="'.$deepness.'js/main.js"></script>
    ';
  }
  
}
?>