<?php


namespace App\Sitemap;


use JetBrains\PhpStorm\Pure;

class Url
{
    protected string $loc;
    protected string $last_mod;
    protected array $images = [];

    /**
     * Url constructor.
     * @param $loc
     * @param $last_mod
     * @param array $images
     */
    public function __construct($loc, $last_mod, array $images = [])
    {
        $this->loc = $loc;
        $this->last_mod = $last_mod;
        $this->images = Image::mapFromArray($images);
    }

    #[Pure] public function __toString(): string
    {
        return <<<STRING
    <url>
        <loc>{$this->_loc}</loc>
        <lastmod>{$this->_last_mod}</lastmod>{$this->listImages()}
    </url>
STRING;
    }

    public function __get($name)
    {
        $length = strlen($name);
        if (
            $length > 2
            && substr($name, 0, 1) == '_'
            && property_exists(self::class, substr($name, 1))
        ) {
            return htmlentities($this->{substr($name, 1)}, ENT_XML1);
        } else {
            return $this->{$name};
        }
    }

    public static function mapFromArray($items): array
    {
        $urls = [];
        foreach ($items as $item) {
            if ($item instanceof Url) {
                $urls[] = $item;
                continue;
            }
            if (isset($item['loc'])) {
                $urls[] = new self(
                    $item['loc'],
                    $item['lastmod'],
                );
            } else {
                $urls[] = new self(
                    $item[0],
                    $item[1],
                );
            }
        }
        return $urls;
    }

    protected function listImages()
    {
        if (count($this->images)) {
            return "\n" . implode("\n", $this->images);
        } else {
            return "";
        }
    }
}
