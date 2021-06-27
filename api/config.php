<?php

class Config {
    const DATE_FORMAT = "Y-m-d H:i:s";
    const JWT_SECRET = "JWT_SECRET";

    public static function DB_HOST(){
        return Config::get_env("DB_HOST", "soundbank-db-do-user-9216819-0.b.db.ondigitalocean.com");
      }
      public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", "doadmin");
      }
      public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", "il2eoqw5yy0uf4qs");
      }
      public static function DB_PORT(){
        return Config::get_env("DB_PORT", "3306");
      }
      public static function DB_SCHEME(){
        return Config::get_env("DB_SCHEME", "Soundbank");
      }
      public static function SMTP_HOST(){
        return Config::get_env("SMTP_HOST", "smtp.mailgun.org");
      }
      public static function SMTP_PORT(){
        return Config::get_env("SMTP_PORT", "587");
      }
      public static function SMTP_USER(){
        return Config::get_env("SMTP_USER", "postmaster@soundbank.games");
      }
      public static function SMTP_PASSWORD(){
        return Config::get_env("SMTP_PASSWORD", "12cdd9faf4e452ba01b24aef8cf2e6b8-6ae2ecad-b9141933");
      }

      public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
      }

    /*const DB_HOST = "soundbank-db-do-user-9216819-0.b.db.ondigitalocean.com";
    const DB_USERNAME = "il2eoqw5yy0uf4qs";
    const DB_PASSWORD = "berina123";
    const DB_NAME = "soundbank";

    const SMTP_HOST = "smtp.mailgun.org";
    const SMTP_PORT = 587;
    const SMTP_USERNAME = "postmaster@soundbank.games";
    const SMTP_PASSWORD = "12cdd9faf4e452ba01b24aef8cf2e6b8-6ae2ecad-b9141933";*/
}

?>