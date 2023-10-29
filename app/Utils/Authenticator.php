<?php
/**
 * Authenticator - Provides methods to autenticate the request
 */
class Authenticator
{  
  /**
   * authenticate - Retrieves the request header and manages authentication mathods
   *
   * @return bool - Returns positive or false authenticate result
   */
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
  
  /**
   * isValidToken - Validate access token
   *
   * @param  string $authorization - Base64 encrypted token
   * @return bool - Returns positive or false of token validation
   */
  private static function isValidToken(string $authorization): bool
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
  
  /**
   * isValidContentType - Validate Content-Type
   *
   * @param  string $contentType
   * @return bool - Returns positive or false of Content-Type validation
   */
  private static function isValidContentType(string $contentType): bool
  {
    if (empty($contentType) or $contentType !== 'application/json') {
      return false;
    }

    return true;
  }
}