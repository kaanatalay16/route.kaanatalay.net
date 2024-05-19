<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TomTomMap extends Widget
{
    protected static string $view = 'filament.widgets.tom-tom-map';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';




}
