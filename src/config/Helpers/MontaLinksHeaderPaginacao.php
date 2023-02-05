<?php
/**
 * Created by PhpStorm.
 * User: rupertlustosa
 * Date: 15/11/15
 * Time: 10:37
 */

namespace App\Helpers;

class MontaLinksHeaderPaginacao
{
    public static function MontaLinksHeaderPaginacao($ordenacao, $header, $label){
        $retorno = '
                                <a href="?sort='.$header.'&amp;order='.$ordenacao['reverseOrder'].'">';

        if(\Request::query('sort')==$header and \Request::query('order')=='ASC')
            $retorno .= '                                        <i class="glyphicon glyphicon-chevron-up fa-xs"></i>';
        elseif (\Request::query('sort')==$header and \Request::query('order')=='DESC')
            $retorno .= '                                        <i class="glyphicon glyphicon-chevron-down fa-xs"></i>';
        else if($header == $ordenacao['sort'])
            $retorno .= '                                        <i class="glyphicon glyphicon-chevron-down fa-xs"></i>';
        $retorno .= '                        '.$label.'
                                </a>
        ';
        return $retorno;
    }
}