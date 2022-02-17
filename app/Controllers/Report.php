<?php

namespace App\Controllers;

use CodeIgniter\Database\MySQLi\Result;
use \Mpdf\Mpdf;

class Report extends BaseController
{

    public function index($npm)
    {
        // pengkuluk-kulukkan data
        $mpdf = new Mpdf(['mode' => 'utf-8']);
        $mpdf->WriteHTML(view('welcome_message', ['nama' => $npm]));
        return redirect()->to($mpdf->Output('Test.pdf', 'I'));
    }
}
