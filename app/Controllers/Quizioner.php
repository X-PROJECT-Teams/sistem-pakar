<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Quizioner extends BaseController
{
  public function __construct()
  {
    helper('form');
  }
  public function index(): string
  {
    return view('home/index');
  }
  private function sumScore()
  {
    $score = [
      "kesadaranUmum"
    ];
  }
}
