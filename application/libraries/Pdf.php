<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("mpdf/mpdf.php");
class Pdf extends mPDF {
	public function test() {
		echo "Aaaa";die;
	}
}
