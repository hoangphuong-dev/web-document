<?php

use App\Enums\Common\AlertType;
use App\Enums\Payment\DeviceType;
use Helpers\KeywordLibrary;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Jenssegers\Agent\Agent;


if (!function_exists('is_mobile_site')) {
    function is_mobile_site(): bool
    {
        $agent = new \Jenssegers\Agent\Agent();
        return $agent->isPhone();
    }
}

if (!function_exists('convertToUtf8')) {
    function convertToUtf8(string $text): bool|string
    {
        $encoding = mb_detect_encoding($text, mb_detect_order());

        if ($encoding == 'UTF-8' || $encoding === false) {
            $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        }

        return iconv(mb_detect_encoding($text, mb_detect_order()), 'UTF-8//IGNORE', $text);
    }
}

if (!function_exists('get_svg')) {
    function get_svg(string $path, string $class = ''): false|string
    {
        // Create the dom document as per the other answers
        $svg = new \DOMDocument();
        $svg->load(public_path('images/icons/' . $path . '.svg'));
        // Thực hiện thay thế bằng hàm strtr
        $newClass = strtr($class, config('obfuscate-class', []));
        $svg->documentElement->setAttribute("class", $newClass);
        return $svg->saveXML($svg->documentElement);
    }
}

if (!function_exists('current_url')) {
    function current_url()
    {
        return session()->get('web_current_url', route('index'));
    }
}

if (!function_exists("get_user_ip_address")) {
    function get_user_ip_address()
    {
        return $_SERVER['HTTP_CLIENT_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['HTTP_X_FORWARDED']
            ?? $_SERVER['HTTP_FORWARDED_FOR']
            ?? $_SERVER['HTTP_FORWARDED']
            ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }
}


if (!function_exists('notify')) {
    function notify(mixed $message, string $type = AlertType::NOTIFY): void
    {
        if (in_array($type, AlertType::asArray())) {
            session()->flash($type, $message);
        }
    }
}

if (!function_exists('random_str')) {
    function random_str(int $number): string
    {
        $name = '';
        for ($i = 0; $i < $number; $i++) {
            $name .= chr(rand(97, 122));
        }
        return $name;
    }
}

if (!function_exists('generate_name')) {
    function generate_name(string $filename): string
    {
        $name = random_str(3);
        $name .= time();
        $ext  = strtolower(substr($filename, (strrpos($filename, '.') + 1)));
        return $name . '.' . $ext;
    }
}

if (!function_exists('format_log_message')) {
    function format_log_message($e, string $extra = ''): string
    {
        $exceptException = [
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Session\TokenMismatchException::class,
        ];

        if (method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();
        } elseif (method_exists($e, 'getStatus')) {
            $statusCode = $e->getStatus();
        } else {
            $statusCode = $e->status ?? $e->statusCode ?? 500;
        }

        if (method_exists($e, 'getMessage') && ($statusCode != 500 || in_array(get_class($e), $exceptException))) {
            $e = $e->getMessage();
        }

        if (is_array($e)) {
            $stringError = var_export($e, true);
        } elseif ($e instanceof Jsonable) {
            $stringError = $e->toJson();
        } elseif ($e instanceof Arrayable) {
            $stringError = var_export($e->toArray(), true);
        } else {
            $stringError = (string) $e;
        }

        if ($statusCode == 500 && method_exists($e, 'getMessage')) {
            $msg = $e->getMessage();
        } else {
            $msg = '';
        }

        $addIp  = '';
        $append = '';
        if (!app()->runningInConsole()) {
            $addIp  .= '[ip: ' . get_user_ip_address() . '] ';
            $append .= '[Request: ' . request()?->fullUrl() . '] ';
        }
        $addIp .= "[error_code: {$statusCode}] ";

        return "{$addIp}{$extra}{$msg}\n\n{$stringError}\n\n{$append}";
    }
}


if (!function_exists('word_count')) {
    function word_count($str, $n = '0'): array|int
    {
        $m = strlen($str) / 2;
        $a = 1;
        while ($a < $m) {
            $str = str_replace('  ', ' ', $str);
            $a++;
        }
        $b = explode(' ', $str);
        $i = 0;
        foreach ($b as $v) {
            $i++;
        }
        if ($n == 1) {
            return $b;
        } else {
            return $i;
        }
    }
}

if (!function_exists('generate_qr')) {
    function generate_qr(string $bank, $acc, $money, $desc): string
    {
        return "https://qr.sepay.vn/img?bank={$bank}&acc={$acc}&template=compact&amount={$money}&des={$desc}";
    }
}

if (!function_exists('deviceCurrent')) {
    function deviceCurrent(): int
    {
        return app(Agent::class)->isMobile() ? DeviceType::MOBILE : DeviceType::PC;
    }
}

if (!function_exists('ext_change')) {
    function ext_change(string $fileName, string $ext): string
    {
        $fileName = KeywordLibrary::removeExt($fileName);
        return "{$fileName}.{$ext}";
    }
}

function to_roman($number)
{
    $roman = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII", "XIII", "XIV", "XV", "XVI", "XVII", "XVIII", "XIX", "XX"];
    $romanMap = array_combine(range(1, count($roman)), $roman);
    return Arr::get($romanMap, $number);
}

function data_json_from_gemini_out($output): array
{
    preg_match("/```\s*(json)?(.*)```/si", $output, $matches);
    if ($matches) {
        $json = Arr::get($matches, 2, '');
    } else {
        preg_match("/^\{.*\}$/s", str_replace("\n", "", $output), $matches);
        $json = Arr::get($matches, 0, '');
    }
    return json_decode($json, true) ?? [];
}

if (!function_exists('json_encode_vi')) {
    function json_encode_vi(mixed $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('str_to_array')) {
    function str_to_array(array $value): string
    {
        $result = \Arr::first($value);
        if (is_array($result)) {
            return str_to_array($result);
        }
        return $result;
    }
}

if (!function_exists('make_channel_log')) {
    function make_channel_log(string $name): string
    {
        if (in_array($name, array_keys(config('logging.channels', [])))) {
            return $name;
        }

        $env     = app()->runningInConsole() ? 'cli' : 'web';
        $channel = "{$name}_{$env}";
        if (in_array($channel, array_keys(config('logging.channels', [])))) {
            return $channel;
        }
        return "daily_{$env}";
    }
}

if (!function_exists('check_word_count')) {
    function check_word_count(string $text, int $min = 5, int $max = 10): bool
    {
        $countWord = count(explode(' ', $text));
        if ($countWord >= $min && $countWord <= $max) {
            return true;
        }
        return false;
    }
}
