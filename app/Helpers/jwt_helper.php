<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;


function getJWTFromRequest($authenticationHeader)
{
  if (is_null($authenticationHeader)) {
    throw new Exception('Missing or invalid JWT in request');
  }
  return explode(' ', $authenticationHeader)[0];
}

function validateJWTFromRequest(string $encodedToken)
{
  $key = Services::getSecretKey();
  $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
  $userModel = new UserModel();
  $userModel->findUserByEmail($decodedToken->data->email);
}
function getJWTData(string $encodedToken)
{
  $key = Services::getSecretKey();
  $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
  return $decodedToken;
}


function getSignedJWTForUser(array $user)
{
  $issuedAtTime = time();
  $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
  $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
  $notBeforeClaim = $issuedAtTime;                  // get RSA private key (NOT IN USE)
  $payload = [
    "iss" => "https://dehidrasi.wtwbuilding.my.id", // this can be the servername. Example: https://domain.com
    "aud" => $user['name'],
    "sub" => $user['id'],
    "nbf" => $notBeforeClaim,
    'iat' => $issuedAtTime,
    'exp' => $tokenExpiration,
    "data" => array(
      'email' => $user['email'],
      'is_active' => $user['is_active'],
      'is_admin' => $user['is_admin'],
      'name' => $user['name']
    )
  ];


  $jwt = JWT::encode($payload, Services::getSecretKey());
  return [
    'access_token' => $jwt,
    'expired' => $tokenExpiration
  ];
}
