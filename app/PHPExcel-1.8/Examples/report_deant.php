<?php
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$i = 65;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '2011 ዓ/ም ናይ ዞባታት ገጠርን ከተማን ኣባል ውድብ /ዞባ ምዕራብ')
            ->mergeCells('A1:N1')
            ->setCellValue('B2', 'መፍረይቲ')
            ->setCellValue('E2', 'ከ/ሕርሻ')
            ->setCellValue('H2', 'ኮንስትራክሽን')
            ->setCellValue('K2', 'ንግዲ')
            ->setCellValue('N2', 'ግልጋሎት')
            ->setCellValue('Q2', 'ድምር')
            ->setCellValue('A2', 'ወረዳ')
            ->setCellValue('B3', 'ተባ')
            ->setCellValue('C3', 'ኣን')
            ->setCellValue('D3', 'ድምር')
            ->setCellValue('E3', 'ተባ')
            ->setCellValue('F3', 'ኣን')
            ->setCellValue('G3', 'ድምር')
            ->setCellValue('H3', 'ተባ')
            ->setCellValue('I3', 'ኣን')
            ->setCellValue('J3', 'ድምር')
            ->setCellValue('H3', 'ተባ')
            ->setCellValue('I3', 'ኣን')
            ->setCellValue('J3', 'ድምር')
            ->setCellValue('K3', 'ተባ')
            ->setCellValue('L3', 'ኣን')
            ->setCellValue('M3', 'ድምር')
            ->setCellValue('N3', 'ተባ')
            ->setCellValue('O3', 'ኣን')
            ->setCellValue('P3', 'ድምር')
            ->mergeCells('A2:A3')
            ->mergeCells('B2:D2')
            ->mergeCells('E2:G2')
            ->mergeCells('H2:J2')
            ->mergeCells('K2:M2')
            ->mergeCells('N2:P2')
            ->mergeCells('Q2:Q3');
$arr = [['ወልቃይት', 5769, 1643,7412,298,150,448,298,205,592,365,135,500,365,135,500],['ወልቃይት', 5769, 1643,7412,298,150,448,298,205,592,365,135,500,365,135,500]];
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




