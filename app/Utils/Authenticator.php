<?php
class Authenticator
{
  public static function authenticate(): bool
  {
    $allHeaders = getallheaders();
    $contentType = $allHeaders['Content-Type'] ?? '';
    $authorization = $allHeaders['Authorization'] ?? '';

    if (self::isValidToken($authorization) and self::isValidContentType($contentType)) {
      return true;
    }

    return false;
  }

  private static function isValidToken($authorization): bool
  {
    if (empty($authorization) or strpos($authorization, 'Bearer ') === false) {
      return false;
    }
    
    $token = str_replace('Bearer ', '', $authorization);
    $arrayKeys = explode(':', base64_decode($token));

    if ($arrayKeys[0] === PUBLIC_KEY and $arrayKeys[1] === SECRET_KEY) {
      return true;
    }

    return false;
  }

  private static function isValidContentType($contentType): bool
  {
    if (empty($contentType) or $contentType !== 'application/json') {
      return false;
    }

    return true;
  }
}