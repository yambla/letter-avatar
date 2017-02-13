<?php

namespace YoHang88\LetterAvatar;

use Intervention\Image\ImageManager;

class LetterAvatar
{
    /**
     * @var string
     */
    protected $name;


    /**
     * @var string
     */
    protected $name_initials;


    /**
     * @var string
     */
    protected $shape;


    /**
     * @var int
     */
    protected $size;
    
    /**
     * @var array
     */
    protected $colors;
    
    /**
     * @var string
     */
    protected $font = null;


    /**
     * @var ImageManager
     */
    protected $image_manager;
    
    /**
     * @var array
     */
    protected $numbers = array(
		1 => 'F',
		2 => 'H',
		3 => 'Q',
		4 => 'V',
		5 => 'Y',
		6 => 'Z',
		7 => 'O',
		8 => 'B',
		9 => 'C',
		0 => 'X',
    );


    public function __construct($name, $shape = 'circle', $size = '48', array $colors = [])
    {
        $this->setName($name);
        $this->setImageManager(new ImageManager());
        $this->setShape($shape);
        $this->setSize($size);
        $this->setColors($colors);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        return $this->image_manager;
    }

    /**
     * @param ImageManager $image_manager
     */
    public function setImageManager(ImageManager $image_manager)
    {
        $this->image_manager = $image_manager;
    }

    /**
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param string $shape
     */
    public function setShape($shape)
    {
        $this->shape = $shape;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param array $size
     */
    public function setColors(array $colors)
    {
        $this->colors = $colors;
    }
    
    /**
     * @return array
     */
    public function getColors()
    {
        return $this->colors;
    }


    /**
     * @param array $size
     */
    public function setFont($font)
    {
        $this->font = $font;
    }
    
    /**
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @return \Intervention\Image\Image
     */
    public function generate()
    {
        $words = $this->break_words($this->name);

        $number_of_word = 1;
        foreach ($words as $word) {

            if ($number_of_word > 2)
                break;

            $this->name_initials .= strtoupper(trim($word[0]));

            $number_of_word++;
        }

		if(empty($this->getColors()))
			$colors = [
				"#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
				"#f1c40f", "#e67e22", "#e74c3c", "#a5a8a8", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
			];
		else
			$colors = $this->getColors();

        $color_length = count($colors);
        $color_number = hexdec(substr(md5($this->name), 16));
        $color_index  = (int)fmod($color_number, $color_length);
        $color        = $colors[$color_index];


        if ($this->shape == 'circle') {
            $canvas = $this->image_manager->canvas(480, 480);
            if($number_of_word == 2) {
				$in = 235;
			} else {
				$in = 245;
			}
			$canvas->circle(455, $in, 240, function ($draw) use ($color) {
                $draw->background($color);
            });

        } else {

            $canvas = $this->image_manager->canvas(480, 480, $color);
        }
        
        $ufont = $this->font;

        $canvas->text($this->name_initials, 240, 240, function ($font) use ($ufont) {
            if(!is_null($ufont) && strpos($ufont, '/') === FALSE)
                $ufont = __DIR__ . '/fonts/'.$ufont;
            else
                $ufont = __DIR__ . '/fonts/arial-bold.ttf';
            $font->file($ufont);
            $font->size(220);
            $font->color('#ffffff');
            $font->valign('middle');
            $font->align('center');
        });

        return $canvas->resize($this->size, $this->size);
    }

    public function __toString()
    {
        return (string) $this->generate()->encode('data-url');
    }

    public function break_words($name) {
        $temp_word_arr = explode(' ', $name);
        $final_word_arr = array();
        foreach ($temp_word_arr as $key => $word) {
            if( $word != "" && $word != ",") {
                $final_word_arr[] = $word;
            }
        }
        return $final_word_arr;
    }

}
