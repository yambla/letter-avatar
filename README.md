# Letter Avatar for PHP

Generate user avatar using name initials letter.

![letter-avatar](https://cloud.githubusercontent.com/assets/618412/12192012/835c7488-b60d-11e5-9276-d06f42d11a86.png)

## Features
* Data URI image ready (also save as PNG/JPG).
* Consistent color.
* Customize size, shape: square, circle.
* Small, fast.

## Install

Via Composer

``` bash
$ composer require symforge/letter-avatar
```

### Implementation

``` php
<?php

use YoHang88\LetterAvatar\LetterAvatar;

$avatar = new LetterAvatar('Steven Spielberg');

// Square Shape, Size 64px
$avatar = new LetterAvatar('Steven Spielberg', 'square', 64);

// Improved version:

$avatar = new LetterAvatar('Steven Spielberg', 'square', 64, ['#000000', '#dcdcdc']);
$avatar->setFont('OpenSans-Regular.ttf'); // you can use only filenames if you intend to use our own repo fonts otherwise
										  // use full relative path to your font.
$avatar->setColors(['#000000', '#dcdcdc', ....]); // you can pass this from constructor.


```

``` html
<img src="<?php echo $avatar ?>" />
```
