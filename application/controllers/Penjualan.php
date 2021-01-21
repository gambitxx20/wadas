<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	function __construct() 
        {
            parent::__construct();
            if ($this->session->userdata('logged')<>1) {
	           redirect(site_url('login'));
            }
            		
        }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('Penjualan');
	}

	public function order()
	{
		$this->load->view('Add_order');
	}

	public function edit($id){
		$data = array(
			'id' => $id
		);
		$this->load->view('Edit_barang',$data);
	}

	public function export_sales(){
		
		

		$this->load->library('excel');
        $listInfo = $this->order_model->showAll()->result();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Order ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'customer Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Total Item');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Payment Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Total Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Order Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Payment Time'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Order Taker'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Cashier');   
        $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
       /* foreach(range('A','J') as $columnID) {
		    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
		        ->setAutoSize(true);
		}
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');
		        // set Row
        $rowCount = 2;
        $x = 1;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $x++);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->order_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list->nama_perusahaan);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list->order_qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list->order_harga);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list->nama_barang);
            $rowCount++;
        }*/
        $filename = "Stellar_Sales_Report_". date("Y-m-d-H-i-s").".xlsx";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
        $objWriter->save('php://output'); 
	}
}
