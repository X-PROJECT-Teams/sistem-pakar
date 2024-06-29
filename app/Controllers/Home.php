<?php

namespace App\Controllers;

use App\Libraries\Authentication;
use App\Models\QuizionerModel;
use App\Models\SessionModel;
use App\Models\UserModel;
use Config\Services;

class Home extends BaseController
{
    public function __construct()
    {
        helper(["jwt", "form"]);
    }
    public function index()
    {
        $session  = session();
        $userModel = new UserModel();
        $token = Services::request()->getCookie("access_token");
        $questionModel = new QuizionerModel();
        $dataQuestion = $questionModel->findAllWithDetail();
        if ($token) {
            $data = getJWTData($token);
            $data = $userModel->findUserByEmail($data->data->email);
            unset($data['password']);
            return view('home/home-page', [
                'username' => $data['username'],
                'is_admin' => $data['is_admin'],
                'questions' => $dataQuestion,
                'success_insert' => $session->get("success_insert")
            ]);
        }

        return view('home/home-page', ['questions' => $dataQuestion]);
        //return view('home/index', ['questions' => $dataQuestion]);
    }
    public function informasi()
    {
        $session  = session();
        $userModel = new UserModel();
        $token = Services::request()->getCookie("access_token");
        $questionModel = new QuizionerModel();
        $dataQuestion = $questionModel->findAllWithDetail();
        if ($token) {
            $data = getJWTData($token);
            $data = $userModel->findUserByEmail($data->data->email);
            unset($data['password']);
            return view('home/quiz', [
                'username' => $data['username'],
                'is_admin' => $data['is_admin'],
                'questions' => $dataQuestion,
                'success_insert' => $session->get("success_insert")
            ]);
        }

        return view('home/informasi', ['questions' => $dataQuestion]);
    }
    public function quiz()
    {
        $session  = session();
        $userModel = new UserModel();
        $token = Services::request()->getCookie("access_token");
        $questionModel = new QuizionerModel();
        $dataQuestion = $questionModel->findAllWithDetail();
        if ($token) {
            $data = getJWTData($token);
            $data = $userModel->findUserByEmail($data->data->email);
            unset($data['password']);
            return view('home/quiz', [
                'username' => $data['username'],
                'is_admin' => $data['is_admin'],
                'questions' => $dataQuestion,
                'success_insert' => $session->get("success_insert")
            ]);
        }

        return view('home/quiz', ['questions' => $dataQuestion]);
    }
    public function errorPage()
    {
        return view("errors/html/error_404.php");
    }
    public function getHasil()
    {
        $args = array(
            $this->request->getPost("kesadaran_umum"),
            $this->request->getPost("mata"),
            $this->request->getPost("air_mata"),
            $this->request->getPost("mulut_dan_lidah"),
            $this->request->getPost("rasa_haus"),
            $this->request->getPost("cubitan_kulit"),
            $this->request->getPost("ekstremitas"),
            $this->request->getPost("kencing")
        );
        $intArgs = array_map('intval', $args);
        $total = array_sum($intArgs);

        $status = null;
        if ($total >= 17) {
            $status = "Dehidrasi berat";
        } else if ($total >= 9) {
            $status = "Dehidrasi ringan-sedang";
        } else if ($total <= 8) {
            $status = "Tanpa Dehidrasi";
        }
        $statusDehidrasi = $this->conversiStatusDehidrasi($total);
        $data = array(
            "respon" => TRUE,
            "score" => $total,
            "status" => $status,
            "pelaksanaan" => $this->getDeskripsiDehidrasi($statusDehidrasi),
            "tingkat" => $this->getDeskripsiTingkat($statusDehidrasi),
            "dampak" => $this->getDampak($statusDehidrasi),
            "stat" => $statusDehidrasi

        );
        return view('home/index', $data);
    }
    private function getDampak(string $status)
    {
        if ($status == "ringan" || $status == "sedang") {
            return "rasa lelah, gelisah, menggangu mood, dan penurunan daya ingat jangka pendek, kenaikan suhu tubuh, pusing dan sakit kepala, rasa haus meningkat, kulit kering.";
        } else if ($status == "berat") {
            return "penurunan kesadaran, masalah pada ginjal, kram pada otot, penurunan tekanan darah dan sesak napas, hingga kematian.";
        }
    }
    private function conversiStatusDehidrasi(int $score)
    {
        if ($score >= 17) return "berat";
        if ($score >= 12) return "sedang";
        if ($score >= 9) return "ringan";
        return "tanpa";
    }
    private function getDeskripsiTingkat(string $status)
    {
        if ($status == "ringan") {
            return "Ditandai dengan rasa haus, sakit kepala, kelelahan, wajah memerah, mulit dan kerongkongan kering. Dehidrasi ringan ini merupakan dehidrasi yang terjadi dalam jangka waktu pendek dan tidak terlalu parah tetapi apabila dibiarkan maka akan berdampak buruk bagi kesehatan tubuh. Kehilangan Berat badan < 3%";
        } else if ($status == "sedang") {
            return "Ditandai dengan detak jantung yang cepat, pusing, tekanan darah rendah, lemah, volume urin rendah namun konsentrasinya tinggi. Kehilangan Berat Badan 3%-9%.";
        } else if ($status == "berat") {
            return "Ditandai dengan kejang otot, lidah bengkak (swollen tongue), sirkulasi darah tidak lancar, tubuh semakin melemah dan kegagalan fungsi ginjal. Dehidrasi berat ini merupakan dehidrasi jangka panjang yang dapat berdampak buruk bagi kesehatan bahkan dapat menyebabkan kematian. Kehilangan berat badan >9%.";
        }
    }
    private function getDeskripsiDehidrasi(string $status)
    {
        if ($status == "ringan" || $status == "sedang") {
            return "Derajat ringan sedang dapat diatasi secara efektif dengan pemberian oral rehydration solution (ORS) untuk mengembalikan volume intravaskuler dan mengoreksi asidosis. 
Larutan rehidrasi oral diracik dari 1 liter air, 8 sendok teh gula, dan 1 sendok teh garam. Pemberian cairan yang tidak tepat, misalkan pada cairan dengan kadar glukosa terlalu tinggi dapat menyebabkan diare yang dapat memperparah keadaan dehidrasi.";
        } else if ($status == "berat") {
            return "Seseorang dengan dehidrasi berat perlu dilakuan rehidrasi dengan segera untuk memperbaiki fungsi jaringan. Pemberian cairan intravena diperlukan utama pemberian cairan dengan cepat, terutama pada orang dengan asupan oral yang tidak adekuat.";
        }
    }
}
