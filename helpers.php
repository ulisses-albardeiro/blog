<?php

function salutation(): string 
{
    $hour = date(strtotime('H'));

    if($hour >= 0 && $hour <=5){
        $salutation = 'boa madrugada';
    }elseif($hour >= 6 && $hour <= 12){
        $salutation = 'bom dia';
    }elseif($hour >= 13 && $hour <= 18){
        $salutation = 'boa tarde';
    }else {
        $salutation = 'boa noite';
    }

    return $salutation;
}

function summarizeText(string $text, int $limit, string $continues = '...'): string 
{
    $cleanText = strip_tags(trim($text));
    if(mb_strlen($cleanText) <= $limit){
        return $cleanText;
    }

    $summarizeText = mb_substr($cleanText, 0,mb_strrpos(mb_substr($cleanText, 0, $limit),''));

    return $summarizeText.$continues;
}

function TimeConunt(string $date) : string
{
    $now = strtotime(date('Y-m-d H:i:s'));
    $time = strtotime($date);
    $difference = $now - $time;
    
    $seconds = $difference;
    $minutes = round($difference / 60);
    $hours = round($difference / 3600);
    $days = round($difference / 86400);
    $weeks = round($difference / 604800);
    $months = round($difference / 2419200);
    $yers = round($difference / 29030400);

    if($seconds <= 60){
        return 'agora';
    }elseif($minutes <= 60){
        return $minutes == 1 ? 'há 1 minuto' : 'há '.$minutes.' minutos';
    }elseif($hours <= 24){
        return $hours == 1 ? 'há 1 hora' : 'há '.$hours.' horas';
    }elseif($days <= 30){
        return $days == 1 ? 'há 1 dia' : 'há '.$days.'dias ';
    }elseif($weeks <= 4){
        return $weeks == 1 ? 'há 1 semana' : 'há '.$weeks.' semanas';
    }elseif($months <= 12){
        return $months == 1 ? 'há 1 mês' : 'há '.$months.' meses';
    }else{
        return $yers == 1 ? 'há 1 ano' : 'há '.$yers.' anos';
    }
}