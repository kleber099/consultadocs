<?php

/**
 * Created by PhpStorm.
 * User: klebe
 * Date: 15/03/2018
 * Time: 23:31
 */
class Conexao
{
    private static $HOST = 'localhost';
    private static $BANCO = 'consultadocs';
    private static $PORTA = '5432';
    private static $USUARIO = 'postgres';
    private static $SENHA = 'root';


    public static function getConexao() {
        return pg_connect(
            "host=" . self::$HOST .
            " dbname=".self::$BANCO.
            " port=".self::$PORTA.
            " user=". self::$USUARIO.
            " password=".self::$SENHA);
    }
}