<?php
class Token {
  public static function encode($payload, $key) {
    $json = json_encode($payload);
    $base64 = base64_encode($json);
    $secret = base64_encode(hash('md5', $key));
    $token = base64_encode("$base64.$secret");
    return $token;
  }
  public static function decode($token, $key) {
    $string = base64_decode($token);
    $tkn = explode('.', $string);
    $secret = hash('md5', $key);
    if (base64_decode($tkn[1]) == $secret) return json_decode(base64_decode($tkn[0]), true);
    else throw new Exception ('Token signature is invalid');
  }
}
?>