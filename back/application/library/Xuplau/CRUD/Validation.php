<?php
Namespace Xuplau\CRUD;
use Respect\Validation\Validator as v;

Class Validation
{

    static function Password() {
        return v::string()->notEmpty()->noWhitespace()->length(4,null);
    }

    static function User() {
        return v::string()->notEmpty()->noWhitespace();
    }

    static function Login() {
        return v::arr()
                ->key('user', Validation::User())
                ->key('pwd',  Validation::Password());
    }

    static function ResponseString() {
        return v::string()->notEmpty()->noWhitespace();
    }

    static function InfoHash() {
        return v::string()->notEmpty()->noWhitespace()->length(64,64);
    }

    static function InfoText() {
        return v::string()->notEmpty()->length(4,null);;
    }

    static function InfoData() {
        return v::date('d/m/Y');
    }
}