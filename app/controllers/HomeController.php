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
            // memRedis-start
            $client = new Redis();
            $client->connect('127.0.0.1', 6379);
            $pool = new \Cache\Adapter\Redis\RedisCachePool($client);
            $simpleCache = new \Cache\Bridge\SimpleCache\SimpleCacheBridge($pool);
//            $simpleCache->set('A', 'A1');
            \PhpOffice\PhpSpreadsheet\Settings::setCache($simpleCache);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Hello World !');
            $writer = new Xlsx($spreadsheet);
            $writer->save('htest.xlsx');
            // 释放内存
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
            exit;


            // 通过工厂模式创建内容
//            $spreadsheet = IOFactory::load(dirname(__FILE__) . '/../../vendor/phpoffice/phpspreadsheet/samples/templates/26template.xlsx');
//            $worksheet = $spreadsheet->getActiveSheet();
//            $worksheet->getCell('A1')->setValue('John');
//            $worksheet->getCell('A2')->setValue('Smith');
//            // 通过工厂模式来写内容
//            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
//            $writer->save('hwrite.xls');

            exit;
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
//            header('Cache-Control: max-age=0');//禁止缓存
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @desc PHPExcel下载方式
     */
    public function phpExcel()
    {
        include('/Users/hwbaker/Sites/MFFC/vendor/PHPExcel-1.8/Classes/PHPExcel.php');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize'=>'16MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $down = $this->_exportPhpExcel(
            array('姓名','年龄'),
            array(array('LILY', 21), array('LUCY',23)),
            'HExport',
            './', false
        );
        print_r($down);
    }

    /**
     * @param array $title
     * @param array $data
     * @param string $fileName
     * @param string $savePath
     * @param bool $isDown
     * @return string
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Writer_Exception
     */
    private function _exportPhpExcel($title=array(), $data=array(), $fileName='', $savePath='./', $isDown=false)
    {

        $obj = new PHPExcel();

        //横向单元格标识
        $cellName = array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q',
            'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI',
            'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
        );

        $obj->getActiveSheet(0)->setTitle('sheet名称');   //设置sheet名称
        $_row = 1;   //设置纵向单元格标识
        if($title){
            $_cnt = count($title);
            $obj->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格
            $obj->setActiveSheetIndex(0)->setCellValue('A'.$_row, '数据导出：'.date('Y-m-d H:i:s'));  //设置合并后的单元格内容
            $_row++;
            $i = 0;
            foreach($title AS $v){   //设置列标题
                $obj->setActiveSheetIndex(0)->setCellValue($cellName[$i].$_row, $v);
                $i++;
            }
            $_row++;
        }

        //填写数据
        if($data){
            $i = 0;
            foreach($data AS $_v){
                $j = 0;
                foreach($_v AS $_cell){
                    $obj->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell);
                    $j++;
                }
                $i++;
            }
        }

        //文件名处理
        if(!$fileName){
            $fileName = uniqid(time(),true);
        }

        $objWrite = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');

        if($isDown){   //网页下载
            header('pragma:public');
            header("Content-Disposition:attachment;filename=$fileName.xls");
            $objWrite->save('php://output');
            exit;
        }

        $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码
        $_savePath = $savePath.$_fileName.'.xlsx';
        $objWrite->save($_savePath);

        return $savePath.$fileName.'.xlsx';
    }
}