<?php
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '2011 ዓ/ም ናይ ዞባታት ገጠርን ከተማን ኣባል ውድብ /ዞባ ምዕራብ')
            ->setCellValue('B2', 'ገጠር')
            ->setCellValue('E2', 'ከተማ')
            ->setCellValue('H2', 'ጠ/ድምር')
            ->setCellValue('A3', 'ወረዳ')
            ->setCellValue('B3', 'ተባ')
            ->setCellValue('C3', 'ኣን')
            ->setCellValue('D3', 'ድምር')
            ->setCellValue('E3', 'ተባ')
            ->setCellValue('F3', 'ኣን')
            ->setCellValue('G3', 'ድምር')
            ->setCellValue('H3', 'ተባ')
            ->setCellValue('I3', 'ኣን')
            ->setCellValue('J3', 'ድምር')
            ->mergeCells('A1:J1')
            ->mergeCells('B2:D2')
            ->mergeCells('E2:G2')
            ->mergeCells('H2:J2');
$arr = [['ወልቃይት', 5769, 1643,7412,298,150,448,298,205,592,365,135,500],['ወልቃይት', 5769, 1643,7412,298,150,448,298,205,592,365,135,500]];
$i = 4;
foreach ($arr as $a) {
      for ($b=0;$b<count($a);$b++) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
      }
      $i++;
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));