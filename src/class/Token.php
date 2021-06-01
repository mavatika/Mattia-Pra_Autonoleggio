<?php
class Token {
  public static function encode (array $payload, string $key, array $options = null) {
    if (empty($payload)) throw new TokenException ('Payload is required');
    if (empty($key)) throw new TokenException ('Key is required');
    if (!empty($options['expiresIn']) && !is_int($options['expiresIn'])) throw new TokenException ('expiresIn option must be of the type integer');
    
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
    if (empty($key)) throw new TokenException ('Key is required');

    $exploded = explode('.', $token);
    if (count($exploded) != 3) throw new TokenException('Token is miseconcoded');

    list($header_base, $payload_base, $sign) = $exploded;

    $header = json_decode(base64_decode($header_base), true);
    $payload = json_decode(base64_decode($payload_base), true);

    if ($header['alg'] != 'sha256') throw new TokenException('Token algorithm not supported');    

    $signature = hash_hmac($header['alg'], "$header_base.$payload_base", $key);
    if ($sign != $signature) throw new TokenException('Signature invalid');

    if (empty($payload['iat']) || (!empty($payload['iat']) && $payload['iat'] > time())) throw new TokenException('The token is corrupted');
    if (!empty($payload['exp']) && $payload['exp'] < time()) throw new TokenException('The token is expired');

    unset($payload['iat']);
    unset($payload['exp']);

    return $payload;
  }
}
?>