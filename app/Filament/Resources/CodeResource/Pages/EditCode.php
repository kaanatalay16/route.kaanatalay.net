<?php

namespace App\Filament\Resources\CodeResource\Pages;

use App\Filament\Resources\CodeResource;
use App\Models\Graph;
use App\Models\Segment;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;


use Illuminate\Database\Eloquent\Model;


class EditCode extends EditRecord
{
    protected static string $resource = CodeResource::class;


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['code'] = Storage::get($data["path"]);


        return $data;
    }



    protected function getHeaderActions(): array
    {
        return [

            // Actions\Action::make('run-code-real')
            //     ->label("Run Code (Latest Route Segments)")
            //     ->action(function () {

            //         Storage::delete("python/distance.png");

            //         $speeds = Segment::where("route_id", 6)->pluck("speed");
            //         $lats = Segment::where("route_id", 6)->pluck("latitude");
            //         $longs = Segment::where("route_id", 6)->pluck("longitude");



            //         $command = '/bin/python3 main.py ' . $speeds . " " . $lats . " " . $longs;
            //         $result = Process::path(Storage::path("python"))->run($command);
            //         // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py [15,25,45] [41.25051,41.25111,41.25111] [29.54,29.54,29.541]');
            //         // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py /bin/python3 main.py [51,51,51] [40.95774,40.95781,40.95785] [29.13587,29.13582,29.13577] ');

            //         $output = json_decode($result->output());


            //         Graph::create([
            //             "route_id" => 6,
            //             "time" => $output->time,
            //             "distance" => $output->distance,
            //             "totalCellPowerEnergyConsumption" => $output->totalCellPowerEnergyConsumption,
            //             "drivingProfile" => $output->drivingProfile,
            //             "batteryPower" => $output->batteryPower,
            //             "soc" => $output->soc,
            //             "capacityRetention" => $output->capacityRetention,
            //         ]);





            //         if (!Storage::fileExists("python/distance.png")) {
            //             Notification::make()
            //                 ->seconds(50)
            //                 ->title('Error - main.py')
            //                 ->danger()
            //                 ->body($command . " " . $result->errorOutput())
            //                 ->send();

            //             return false;
            //         }




            //         Notification::make()
            //             ->title('Saved successfully')
            //             ->success()
            //             ->body('Code runned successfully.')
            //             ->sendToDatabase(auth()->user())
            //             ->send();









            //     }),

            Actions\Action::make('run-code-test')
                ->label("Run Code (Default Parameters)")
                ->color("gray")

                ->action(function () {

                    Storage::delete("python/distance.png");


                    $command = '/bin/python3 main.py [15,25,45] [41.25051,41.25111,41.25111] [29.54,29.54,29.541]';
                    $result = Process::path(Storage::path("python"))->run($command);
                    // $result = Process::path(Storage::path("python"))->run('/bin/python3 main.py /bin/python3 main.py [51,51,51] [40.95774,40.95781,40.95785] [29.13587,29.13582,29.13577] ');


                    if (!Storage::fileExists("python/distance.png")) {
                        Notification::make()
                            ->seconds(50)
                            ->title('Error - main.py')
                            ->danger()
                            ->body($command . " " . $result->errorOutput())
                            ->send();

                        return false;
                    }


                    Notification::make()
                        ->title('Saved successfully')
                        ->success()
                        ->body('Code runned successfully.')
                        ->sendToDatabase(auth()->user())
                        ->send();




                    return redirect("output");







                }),
        ];
    }



    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        if ($data["code"] == null) {
            Notification::make()->danger()->title("Code can not be empty.")->send();
            $this->halt();
        }

        Storage::put($record["path"], $data["code"]);


        $record->update([
            "updated_at" => now()
        ]);

        return $record;
    }


}
