<?php

namespace App\Domain;

class Session
{
  public string $id;
  public string $user_id;
  public  static string $COOKIE_NAME = "X-Project-Session";
}
