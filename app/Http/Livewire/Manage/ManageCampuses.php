<?php

namespace App\Http\Livewire\Manage;
use Filament\Forms;
use Filament\Tables;
use App\Models\Campus;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Exports\CampusExport;
use App\Imports\CampusImport;
use Tables\Columns\TextColumn;

use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification; 
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Contracts\Database\Query\Builder;

class ManageCampuses extends Component implements Tables\Contracts\HasTable 
{

    
    use Tables\Concerns\InteractsWithTable; 
    
    use Forms\Concerns\InteractsWithForms; 

    use Actions;

    protected function getTableQuery(): Builder 
    {
        return Campus::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [    

            Action::make('Import ')
            ->icon('heroicon-o-cloud-upload')
            ->action(function (array $data): void {

            $file  = Storage::disk('public')->path($data['file']);
           
            Excel::import(new CampusImport, $file);

            if (Storage::disk('public')->exists($data['file'])) {

                Storage::disk('public')->delete($data['file']);
            }
        })->icon('heroicon-o-save')->form([
            FileUpload::make('file')->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/csv', 'text/csv', 'text/plain'])->disk('public')->directory('imports')->label('Excel File'),
        ]) ->modalHeading('Notice')
        ->modalSubheading("Please ensure that the file you are importing is in the correct format. You can download the file from the table menu. It is important to note that existing names will be ignored during the data import process into the system"),
            Tables\Actions\ActionGroup::make([

               
            Action::make('download')->icon('heroicon-s-download')->label('Download Template ')
            ->action(function(){

                return Excel::download(new CampusExport, 'campus_template.xlsx');
                // return Excel::download(new CampusExport, 'campus_template.xlsx');
            })
            ->requiresConfirmation()
            ->modalHeading('Notice')
            ->modalSubheading("This template is an Excel data file that contains the correct structure for importing campuses. Please refrain from altering the file's structure. Only add your data following the provided examples. It's important to note that modifying the structure may result in errors when importing the data into the system.")
            ->modalButton('Ok, Download'),
               
                
            ]),

        

            Action::make('create')->button()->icon('heroicon-s-plus')->label('Create New Campus')->action(function($data){
                // dd($data);
                $department = Campus::create(['name' => $data['name']]);
                Notification::make() 
                ->title('Saved successfully')
                ->success()
                ->send();


            })->form([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->unique()
                    ->required(),
            ])->modalHeading('Create Campus'),
        ];

    }

    protected function getTableActions(): array
    {
        return [

            Tables\Actions\ActionGroup::make([

                EditAction::make('update')->label('Update')
                ->action(function (Campus $record, array $data): void {
                        
                    $record->name = $data['name'];
                    $record->save();
              

                    Notification::make() 
                    ->title('Saved successfully')
                    ->success()
                    ->send();
                })
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->required(),
                ])->button()  ->modalHeading('Update Campus'),
    
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
        return view('livewire.manage.manage-campuses');
    }
}
