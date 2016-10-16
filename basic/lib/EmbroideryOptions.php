<?php

class EmbroideryOptions{

  public $colors = [
    'White', 'Ivory', 'Gray', 'Charcoal', 'Black', 'Chesnut', 'Chocolate Brown', 'Pink Frost', 'Pink',
    'Fuchsia', 'Coral', 'Red', 'Burgundy', 'Lavender', 'Purple', 'Light Blue', 'Sky Blue', 'Turquoise', 'Royal Blue',
    'Navy Blue', 'Mint Green', 'Aqua Green', 'Green', 'Olive Green', 'Yellow', 'Gold', 'Metallic Gold'
  ];

  public $fonts = [
    'Mandarin', 'Victorian', 'Old Script', 'French Script', 'Hobo', 'Alex Script', 'Times', 'Bodoni', 'Gentle Touch',
    'Circle', 'Wrexam Script', 'Arial', 'Josphine Script', 'Comic', 'Greek'
  ];

  public $monogramStyle = [
    'label'   => 'Monogram Style',
    'class'   => 'monogram-style',
    'type'    => 'dropdown',
    'options' => ['Boyme', 'Free', 'Vine', 'Formal', 'Serif', 'Circle']
  ];

  public $embroideryType = [
    'label'   => 'Front Embroidery Type',
    'class'   => 'embroidery-type',
    'type'    => 'dropdown',
    'options' => ['Name / Initial', 'Monogram']
  ];

  public $overlayStyle = [
    'label'   => 'Overlay Style',
    'class'   => 'overlay-style',
    'type'    => 'dropdown',
    'options' => [1, 2, 3, 4]
  ];

  public $monogram = [
    'label' => 'Monogram',
    'class'   => 'monogram',
    'type'  => 'text',
    'limit' => 3
  ];

  public $frontChestFirstLine = [
    'label' => 'Front Chest 1st line',
    'class'   => 'front-chest-first-line',
    'type'  => 'text',
    'limit' => 11,
  ];

  public $frontChestSecondLine = [
    'label' => 'Front Chest 2nd line',
    'class'   => 'front-chest-second-line',
    'type'  => 'text',
    'limit' => 11,
  ];

  public $backFirstLine = [
    'label' => 'Back 1st line',
    'class'   => 'back-first-line',
    'type'  => 'text',
    'limit' => 11,
  ];

  public $backSecondLine = [
    'label' => 'Back 2nd line',
    'class'   => 'back-second-line',
    'type'  => 'text',
    'limit' => 11,
  ];

  public $overlayInitial = [
    'label' => 'Overlay Initial',
    'class'   => 'overlay-initial',
    'type'  => 'text',
    'limit' => 11,
  ];

  public $overlayName = [
    'label' => 'Overlay Name',
    'class'   => 'overlay-name',
    'type'  => 'text',
    'limit' => 11,
  ];

  public $frontThreadColor = [];
  public $backThreadColor = [];
  public $initialColor = [];
  public $nameThreadColor = [];
  public $font = [];

   public $options = [
    'front monogram' => [],
    'front 1st line' => [],
    'front 1st line + 2nd line' => [],
    'back 1st line' => [],
    "back+front 1st line" => [],
    "back + front 1st line" => [],
    'back 1st line + 2nd line' => [],
    'back 1st line+2nd line' => [],
    'front 1 + back 2 lines' => [],
    'front 1+back 2 lines' => [],
    'back + front 2 lines' => [],
    'back+front 2 lines' => [],
    'front overlay' => [],
    "embroider front 1" => [],
    "embroider monogram" => [],
    "embroider front 2" => [],
    "embroider overlay" => []
  ];

  public function __construct(){

    $this->frontThreadColor = [
      'label'   => 'Front Thread Color',
      'class'   => 'front-thread-color',
      'type'    => 'dropdown',
      'options' => $this->colors
    ];

    $this->backThreadColor = [
      'label'   => 'Back Thread Color',
      'class'   => 'back-thread-color',
      'type'    => 'dropdown',
      'options' => $this->colors
    ];

    $this->initialColor = [
      'label'   => 'Initial Color',
      'class'   => 'initial-color',
      'type'    => 'dropdown',
      'options' => $this->colors
    ];

    $this->nameThreadColor = [
      'label'   => 'Name Thread Color ',
      'class'   => 'name-thread-color',
      'type'    => 'dropdown',
      'options' => $this->colors
    ];

    $this->font  = [
      'label'   => 'Font',
      'class'   => 'item-font',
      'type'    => 'dropdown',
      'options' => $this->fonts
    ];

    $this->options['front monogram'] = [
      $this->monogramStyle,
      $this->frontThreadColor,
      $this->monogram
    ];
    $this->options['front 1st line'] = [
      $this->embroideryType,
      $this->font,
      $this->frontThreadColor,
      $this->frontChestFirstLine,
      $this->monogramStyle,
      $this->monogram
    ];
    $this->options['front 1st line + 2nd line'] = [
      $this->font,
      $this->frontThreadColor,
      $this->frontChestFirstLine,
      $this->frontChestSecondLine,
    ];
    $this->options['back 1st line'] = [
      $this->font,
      $this->backThreadColor,
      $this->backFirstLine
    ];
    $this->options['back 1st line + 2nd line'] = [
      $this->font,
      $this->backThreadColor,
      $this->backFirstLine,
      $this->backSecondLine
    ];
     $this->options['back 1st line+2nd line'] = [
      $this->font,
      $this->backThreadColor,
      $this->backFirstLine,
      $this->backSecondLine
    ];
    $this->options['back + front 1st line'] = [
      $this->font,
      $this->frontThreadColor,
      $this->backThreadColor,
      $this->frontChestFirstLine,
      $this->backFirstLine
    ];
    $this->options['back+front 1st line'] = [
      $this->font,
      $this->frontThreadColor,
      $this->backThreadColor,
      $this->frontChestFirstLine,
      $this->backFirstLine
    ];
    $this->options['front 1 + back 2 lines'] = [
      $this->font,
      $this->frontThreadColor,
      $this->backThreadColor,
      $this->frontChestFirstLine,
      $this->backFirstLine,
      $this->backSecondLine,
    ];
    $this->options['front 1+back 2 lines'] = [
      $this->font,
      $this->frontThreadColor,
      $this->backThreadColor,
      $this->frontChestFirstLine,
      $this->backFirstLine,
      $this->backSecondLine,
    ];
    $this->options['back+front 2 lines'] = [
      $this->font,
      $this->frontThreadColor,
      $this->backThreadColor,
      $this->frontChestFirstLine,
      $this->frontChestSecondLine,
      $this->backFirstLine,
      $this->backSecondLine,
    ];
    $this->options['back + front 2 lines'] = [
      $this->font,
      $this->frontThreadColor,
      $this->backThreadColor,
      $this->frontChestFirstLine,
      $this->frontChestSecondLine,
      $this->backFirstLine,
      $this->backSecondLine,
    ];
    $this->options['front overlay'] = [
      $this->overlayStyle,
      $this->initialColor,
      $this->nameThreadColor,
      $this->overlayInitial,
      $this->overlayName
    ];
    $this->options['embroider front 1'] = [
      $this->font,
      $this->frontThreadColor,
      $this->frontChestFirstLine
    ];
    $this->options['embroider monogram'] = [
      $this->frontThreadColor,
      $this->monogramStyle,
      $this->monogram
    ];
    $this->options['embroider front 2'] = [
      $this->font,
      $this->frontThreadColor,
      $this->frontChestFirstLine,
      $this->frontChestSecondLine
    ];
    $this->options['embroider overlay'] = [
      $this->overlayStyle,
      $this->initialColor,
      $this->nameThreadColor,
      $this->overlayInitial,
      $this->overlayName
    ];


  }

}


?>
