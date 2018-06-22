<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/28
 * Time: 18:34
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class HomeController extends BaseController
{

    public function warehouse()
    {
        $ware = Warehouse::lists();
        require dirname(__FILE__).'/../views/warehouse.php';
    }

    public function company()
    {
//        $company = Company::all();
//        foreach ($company as $flight) {
//            echo $flight->system_name;
//        }

        $company = Company::where('is_enabled', 1)
            ->orderBy('id', 'desc')
            ->take(100)
            ->get();

        require dirname(__FILE__) . '/../views/company.php';
    }

    /**
     * @desc Excel生成下载->phpspreadsheet
     * @throws Exception
     */
    public function uploadExcel()
    {
        try {
//            $spreadsheet = new Spreadsheet();
//            $sheet = $spreadsheet->getActiveSheet();
//            $sheet->setCellValue('A1', 'Hello World !');
//            $writer = new Xlsx($spreadsheet);
//            $writer->save('htest.xlsx');
//            // 释放内存
//            $spreadsheet->disconnectWorksheets();
//            unset($spreadsheet);


            // 通过工厂模式创建内容
//            $spreadsheet = IOFactory::load(dirname(__FILE__) . '/../../vendor/phpoffice/phpspreadsheet/samples/templates/26template.xlsx');
//            $worksheet = $spreadsheet->getActiveSheet();
//            $worksheet->getCell('A1')->setValue('John');
//            $worksheet->getCell('A2')->setValue('Smith');
//            // 通过工厂模式来写内容
//            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
//            $writer->save('hwrite.xls');

            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('infos');
            $titles = [
                'name' =>'姓名',
                'sex' =>'性别',
                'height' =>'身高',
                'weight' =>'体重',
                'volume' =>'体积',
                'proportion' =>'表面积'
            ];

            $azs = range('A','Z');
            $dataArr['name'] =  array('lily', 'vv');
            $dataArr['sex'] =  array('female', 'male');
            $dataArr['height'] =  array('165cm', '185cm');
            $dataArr['weight'] =  array('50kg', '80kg');
            $dataArr['volume'] =  array(0, 0);
            $dataArr['proportion'] =  array(0, 0);
            // 写入表格数据
            $i = 0;
            foreach ($titles as $name => $title) {
                $spreadsheet->getActiveSheet()->setCellValue(($azs[$i]).'1', $title);
                foreach ($dataArr[$name] as $n => $val) {
                    $spreadsheet->getActiveSheet()->setCellValue(($azs[$i]).($n+2), $val);
                }
                ++$i;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //告诉浏览器输出07Excel文件
//            header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
            header('Content-Disposition: attachment;filename="hwrite2.xlsx"'); //告诉浏览器输出文件名称
            header('Cache-Control: max-age=0');//禁止缓存
//            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//            $writer->save('php://output');

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}