<?php
class Config {
    
    const USER_DATA_FILE_NAME = 'users.dat';

    static function userDataFilePath(){
        return dirname(__FILE__) . '/' . Config::USER_DATA_FILE_NAME;
    }
}
