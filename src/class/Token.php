<?php
class Token {
  public static function encode (array $payload, string $key, array $options = null) {
    if (empty($payload)) throw new Exception ('Payload is required');
    if (empty($key)) throw new Exception ('Key is required');
    
    $header = [
      'alg' => 'sha256',
      'typ' => 'MattiaPraToken'
    ];

    $header_json = json_encode($header);
      $header_base = base64_encode($header_json);

    $payload_json = json_encode(array_merge($payload, [
      'iat' => time(),
      'exp' => !empty($options['expiresIn']) ? (time() + $options['expiresIn']) : null
    ]));
      $payload_base = base64_encode($payload_json);

    $signature = hash_hmac($header['alg'], "$header_base.$payload_base", $key);
    
    return "$header_base.$payload_base.$signature";
  }

  public static function decode (string $token, string $key) {
    if (empty($key)) throw new Exception ('Key is required');

    @list($header_base, $payload_base, $sign) = explode('.', $token);

    if (empty($header_base) || empty($payload_base) || empty($sign)) throw new Exception('Token is miseconcoded');

    $header = json_decode(base64_decode($header_base), true);
    $payload = json_decode(base64_decode($payload_base), true);

    if ($header['alg'] != 'sha256') throw new Exception('Token algorithm not supported');    

    $signature = hash_hmac($header['alg'], "$header_base.$payload_base", $key);
    if ($sign != $signature) throw new Exception('Signature invalid');

    if (empty($payload['iat']) || !empty($payload['iat']) && $payload['iat'] > time()) throw new Exception('The token is corrupted');
    if (!empty($payload['exp']) && $payload['exp'] < time()) throw new Exception('The token is expired');

    unset($payload['iat']);
    unset($payload['exp']);

    return $payload;
  }
}
?>