<?php

namespace App\Sitemap;

use Illuminate\Filesystem\FilesystemAdapter;

class UrlSet {

    protected $prefix = <<<PREFIX
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
PREFIX;
    protected $subfix = <<<SUBFIX
</urlset>

SUBFIX;

    protected $path;
    protected ?FilesystemAdapter $disk = null;
    protected $buffer = '';
    protected $total = 0;

    public function __construct($path, $disk = null) {
        $this->path = $path;
        $this->disk = $disk;
    }

    public function addUrl(Url $url, $save = false) {
        $this->total++;
        $this->buffer .= "\n" . $url;
        if($save){
            $this->save();
        }
    }

    public function addUrls(array $urls = [], $save = true){
        $urls = Url::mapFromArray( $urls );
        $this->total += count($urls);
        $this->buffer .= "\n" . implode( "\n", $urls );
        if($save){
            $this->save();
        }
    }

    public function count(){
        return $this->total;
    }

    public function save($check_hash = true){
        if($check_hash && !$this->isChanged()){
            return;
        }
        if($this->disk){
            $this->disk->put($this->path, $this->contents());
        }else{
            file_put_contents( $this->path, $this->contents() );
        }
    }

    protected function isChanged(){
        $old_hash = md5($this->getFileContents());
        $new_hash = md5($this->contents());
        return $old_hash != $new_hash;
    }

    public function getFileContents() : string {
        if($this->disk){
            return $this->disk->has($this->path) ? $this->disk->read($this->path) : "";
        }else{
            return @file_get_contents( $this->path );
        }
    }

    public function contents() : string {
        return $this->prefix . $this->buffer . "\n" . $this->subfix;
    }

    protected function appendUrl($url, $overwrite = false){
        $string = "\n";
        if(is_array( $url )){
            $string .= implode( "\n", $url);
        }else{
            $string .= $url->__toString();
        }
        $this->appendString($string, $overwrite);
    }

    protected function appendString($string, $overwrite = false){
        $string .= "\n" . $this->subfix;
        if(!file_exists( $this->path) || $overwrite){
            file_put_contents( $this->path, $this->prefix . "\n" . $this->subfix );
        }
        $fh = fopen( $this->path, 'rw+');
        fseek( $fh, -(strlen( $this->subfix ) + 1), SEEK_END);
        fwrite( $fh, $string);
        fclose( $fh );
    }

}
