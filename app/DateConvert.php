<?php
namespace App;


class DateConvert {
    public static function dateValidation($d){
        $pattern = "/^(([12][0-9]|30|0?[1-9])\/(0?[1-9]|1[0-2])\/([12][0-9]{3}))|(0?[1-6])\/13\/([12][0-9]{3})$/";
        if(preg_match($pattern, $d)){
            if(explode("/", $d)[1] != "13"){
                return true;
            }
            else{
                if((int)explode("/", $d)[0] != 6){
                    return true;
                }
                else{
                    if(((int)explode("/", $d)[2] + 1) % 4 == 0){
                        return true;
                    }
                    else
                        return false;
                }
            }
        }
        return false;
    }
    public static function correctDate($date){
        $date = DateConvert::toGregorian($date);
        return date('Y-m-d',strtotime(str_replace('/','-',$date)));
    }
    public static function startDayOfEthiopian($year){
        $newYearDay = floor($year / 100) - floor($year / 400) - 4;
        return (($year - 1 ) % 4 === 3) ? $newYearDay + 1 : $newYearDay;
    }
    public static function toGregorian($d){
        $year = (int)explode("/", $d)[2];
        $month = (int)explode("/", $d)[1];
        $date = (int)explode("/", $d)[0];

        $newYearDay = DateConvert::startDayOfEthiopian($year);
        $gregorianYear = $year + 7;

        $gregorianMonths = [0.0, 30, 31, 30, 31, 31, 28, 31, 30, 31, 30, 31, 31, 30];

        $nextYear = $gregorianYear + 1;
        if(($nextYear % 4 === 0 && $nextYear % 100 != 0) || $nextYear % 400 === 0){
            $gregorianMonths[6] = 29;
        }

        $until = (($month - 1) * 30.0) + $date;
        if($until <= 37 && $year <= 1575){
            $until += 28;
            $gregorianMonths[0] = 31;
        }
        else{
            $until += $newYearDay - 1;
        }

        if($year - 1 % 4 === 3){
            $until += 1;
        }
        $m = 0;
        $gregorianDate;
        for($i=0; $i < count($gregorianMonths); $i++){
            if($until <= $gregorianMonths[$i]){
                $m = $i;
                $gregorianDate = $until;
                break;
            }
            else{
                $m = $i;
                $until -= $gregorianMonths[$i];
            }
        }
        if($m > 4){
            $gregorianYear += 1;
        }
        $order = [8, 9, 10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $gregorianMonths = $order[$m];
        return (string)$gregorianDate . '/' . (string)$gregorianMonths . '/' . (string)$gregorianYear;

    }
    public static function toEthiopian($d){
        $year = (int)explode("/", $d)[2];
        $month = (int)explode("/", $d)[1];
        $date = (int)explode("/", $d)[0];
        // $year = (int)explode("-", $d)[0];
        // $month = (int)explode("-", $d)[1];
        // $date = (int)explode("-", $d)[2];
        if($month === 10 && $date >= 5 && $date <= 14 && $year == 1582){
            return '';
        }
        $gregorianMonths = [0.0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $ethiopianMonths = [0.0, 30, 30, 30, 30, 30, 30, 30, 30, 30, 5, 30, 30, 30, 30];
        if(($year%4===0&&$year%100!=0)||($year%400===0)){
            $gregorianMonths[2] = 29;
        }
        $ethiopianYear = $year - 8;
        if($ethiopianYear%4 ===3){
            $ethiopianMonths[10] = 6;
        }
        $newYearDay = DateConvert::startDayOfEthiopian($year - 8);

        $until = 0;
        for($i = 1; $i < $month; $i++){
            $until += $gregorianMonths[$i];
        }
        $until += $date;

        $tahissas = ($ethiopianYear%4) === 0 ? 26 : 25;
        if($year<1582){
            $ethiopianMonths[1] = 0;
            $ethiopianMonths[2] = $tahissas;
        }
        else if($until <= 277 && $year === 1582){
            $ethiopianMonths[1] = 0;
            $ethiopianMonths[2] =$tahissas;
        }
        else{
            $tahissas = $newYearDay - 3;
            $ethiopianMonths[1] = $tahissas;
        }
        $m;
        $ethiopianDate;
        for($m = 1; $m < count($ethiopianMonths); $m++){
            if($until <= $ethiopianMonths[$m]){
                $ethiopianDate = ($m === 1 || $ethiopianMonths[$m] === 0) ? $until + (30 - $tahissas) : $until;
                break;
            }
            else{
                $until -= $ethiopianMonths[$m];
            }
        }
        if($m > 10){
            $ethiopianYear += 1;
        }
        $order = [0, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 1, 2, 3, 4];
        $ethiopianMonth = $order[$m];
        return (string)$ethiopianDate . '/' . (string)$ethiopianMonth . '/' . (string)$ethiopianYear;
    }
}