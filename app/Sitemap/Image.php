<?php


namespace App\Sitemap;


class Image {
    protected $loc;
    protected $caption;
    protected $geo_location;
    protected $title;
    public static $loc_only = false;
    
    /**
     * Image constructor.
     *
     * @param $loc
     * @param $caption
     * @param $geo_location
     * @param $title
     */
    public function __construct( $loc, $caption = '', $geo_location = '', $title = '' ) {
        $this->loc = $loc;
        $this->caption = $caption;
        $this->geo_location = $geo_location;
        $this->title = $title;
    }
    
    public function __toString() {
        $string[] = "       <image:image>";
        $string[] = "           <image:loc>{$this->_loc}</image:loc>";
        if(!self::$loc_only && $this->caption){
            $string[] = "           <image:caption>{$this->_caption}</image:caption>";
        }
        if(!self::$loc_only && $this->geo_location){
            $string[] = "           <image:geo_location>{$this->_geo_location}</image:geo_location>";
        }
        if(!self::$loc_only && $this->title){
            $string[] = "           <image:title>{$this->_title}</image:title>";
        }
        $string[] = "       </image:image>";
        return implode( "\n", $string);
    }
    
    public function __get( $name ) {
        $length = strlen( $name );
        if($length > 2
           && substr( $name, 0, 1) == '_'
           && property_exists( self::class, substr( $name, 1))){
            return htmlentities( $this->{substr( $name, 1)}, ENT_XML1 );
        }else{
            return $this->{$name};
        }
    }
    
    public static function mapFromArray($items) : array {
        $urls = [];
        foreach ($items as $item){
            if($item instanceof Image){
                $urls[] = $item;
                continue;
            }
            if(isset( $item['loc'])){
                $urls[] = new self(
                    $item['loc'],
                    $item['caption'] ?? '',
                    $item['geo_location'] ?? '',
                    $item['title'] ?? ''
                );
            }else{
                $urls[] = new self(
                    $item[0],
                    $item[1] ?? '',
                    $item[2] ?? '',
                    $item[3] ?? ''
                );
            }
        }
        return $urls;
    }
    
}