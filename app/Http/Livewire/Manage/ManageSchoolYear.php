<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Campus;
use Livewire\Component;
use App\Models\SchoolYear;


use WireUi\Traits\Actions;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;

use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Contracts\Database\Query\Builder;


class ManageSchoolYear extends Component  implements Tables\Contracts\HasTable
{

    use Tables\Concerns\InteractsWithTable;

    use Forms\Concerns\InteractsWithForms;

    use Actions;

    protected function getTableQuery(): Builder
    {
        return SchoolYear::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\TextColumn::make('from')->label('School Year')->formatStateUsing(function ($record) {
                return  $record->from . ' - ' . $record->to;
            })->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->orWhere('from', 'like', "%{$search}%")
                    ->orWhere('to', 'like', "%{$search}%");
            }),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [

            //     Action::make('Import ')
            //     ->icon('heroicon-o-cloud-upload')
            //     ->action(function (array $data): void {

            //     $file  = Storage::disk('public')->path($data['file']);

            //     Excel::import(new CampusImport, $file);

            //     if (Storage::disk('public')->exists($data['file'])) {

            //         Storage::disk('public')->delete($data['file']);
            //     }
            // })->icon('heroicon-o-save')->form([
            //     FileUpload::make('file')->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/csv', 'text/csv', 'text/plain'])->disk('public')->directory('imports')->label('Excel File'),
            // ]) ->modalHeading('Notice')
            // ->modalSubheading("Please ensure that the file you are importing is in the correct format. You can download the file from the table menu. It is important to note that existing names will be ignored during the data import process into the system"),
            //     Tables\Actions\ActionGroup::make([


            //     Action::make('download')->icon('heroicon-s-download')->label('Download Template ')
            //     ->action(function(){

            //         return Excel::download(new CampusExport, 'campus_template.xlsx');
            //         // return Excel::download(new CampusExport, 'campus_template.xlsx');
            //     })
            //     ->requiresConfirmation()
            //     ->modalHeading('Notice')
            //     ->modalSubheading("This template is an Excel data file that contains the correct structure for importing campuses. Please refrain from altering the file's structure. Only add your data following the provided examples. It's important to note that modifying the structure may result in errors when importing the data into the system.")
            //     ->modalButton('Ok, Download'),


            //     ]),



            Action::make('create')->button()->icon('heroicon-s-plus')->label('Set School Year ')->action(function ($data) {

                SchoolYear::create($data);
                // $department = Campus::create(['name' => $data['name']]);
                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            })->form([


                Grid::make(2)
                    ->schema([
                        TextInput::make('from')
                            ->type('number')->label('From')->placeholder(function () {
                                return now()->year;
                            })->required()
                            ->columnSpan(1)
                            ->default(function(){
                                 return (int)now()->format('Y');
                            })
                            ,

                        TextInput::make('to')
                            ->type('number')->label('To')->placeholder(function () {
                                return now()->addYear()->format('Y');
                            })
                            ->required()
                            ->columnSpan(1)
                            ->default(function(){
                                return (int)now()->addYear()->format('Y');
                           })
                            ,
                        // ...
                    ]),




                // Select::make('course_id')
                // ->label('Choose Course')
                // ->options([
                //     '2023'=> 2023,
                //     '2024'=> 2024,
                //     '2025'=> 2025,
                //     '2026'=> 2026,
                //     '2027'=> 2027,
                //     '2028'=> 2028,
                //     '2029'=> 2029,
                //     '2030'=> 2030,
                //     '2031'=> 2021,
                //     '2033'=> 2021,
                //     '2033'=> 2021,
                //     '2034'=> 2021,
                //     '2035'=> 2021,
                //     '2036'=> 2021,
                //     '2037'=> 2021,
                //     '2038'=> 2021,
                //     '2039'=> 2021,
                //     '2040'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                //     '2021'=> 2021,
                // ])->searchable(),
                // DatePicker::make('to')->label('To')
                // ->minDate(now())->displayFormat(''),
            ])->modalHeading('Set    school year'),
        ];
    }

    protected function getTableActions(): array
    {
        return [

            Tables\Actions\ActionGroup::make([

                EditAction::make('update')->label('Update')
                    ->action(function (SchoolYear $record, array $data): void {

                         $record->from = $data['from'];
                         $record->to = $data['to'];
                         $record->save();


                        // Notification::make() 
                        // ->title('Saved successfully')
                        // ->success()
                        // ->send();
                    })
                    ->mountUsing(fn (Forms\ComponentContainer $form, SchoolYear $record) => $form->fill([
                        'from' => $record->from,
                        'to' => $record->to,
                    ]))
                    ->form([
                        
                Grid::make(2)
                ->schema([
                    TextInput::make('from')
                        ->type('number')->label('From')->placeholder(function () {
                            return now()->year;
                        })->required()->columnSpan(1),

                    TextInput::make('to')
                        ->type('number')->label('To')->placeholder(function () {
                            return now()->addYear()->format('Y');
                        })->required()->columnSpan(1),
                    // ...
                ]),
                    ])->button()->modalHeading('Update Campus'),

                DeleteAction::make('Delete')->button()->label('Delete'),

            ]),



        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make(),
        ];
    }
    public function render()
    {
        return view('livewire.manage.manage-school-year');
    }
}
