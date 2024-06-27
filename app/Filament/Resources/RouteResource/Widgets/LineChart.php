<?php

namespace App\Filament\Resources\RouteResource\Widgets;

use Filament\Widgets\ChartWidget;

class LineChart extends ChartWidget
{

    public string $title;
    public string $label;
    public array $labelData;
    public array $datasets;
    public string $info;

    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';



    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
    ];

    public function getHeading(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->info;
    }

    protected function getData(): array
    {
        return [
            'datasets' => $this->datasets,
            'labels' => $this->labelData,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

}
