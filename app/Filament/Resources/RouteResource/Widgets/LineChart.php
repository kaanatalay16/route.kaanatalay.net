<?php

namespace App\Filament\Resources\RouteResource\Widgets;

use Filament\Widgets\ChartWidget;

class LineChart extends ChartWidget
{

    public string $title;
    public string $label;
    public array $labelData;
    public array $data;
    public string $info;

    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';



    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
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
            'datasets' => [
                [
                    'label' => $this->label,
                    'data' => $this->data,
                    "tension" => 0,
                    "pointRadius" => 0,
                    "borderWidth" => 1
                ],
            ],
            'labels' => $this->labelData,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
