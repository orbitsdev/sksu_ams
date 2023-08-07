<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Campus;
use Livewire\Component;
use WireUi\Traits\Actions;
use Forms\ComponentContainer;
use Tables\Columns\TextColumn;
use App\Exports\DepartmentExport;
use App\Imports\DepartmentImport;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Storage;

use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification; 
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Department as DepartmentModel;

class Department extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms
{

    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;
    use Actions;

    protected function getTableQuery(): Builder
    {
        return DepartmentModel::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('campus.name')->label('Campus')->searchable()
            ->formatStateUsing(fn ($state): string => $state ? $state : 'N/A' )
            ->color('danger')
            ,
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [

            Tables\Actions\ActionGroup::make([

                EditAction::make('update')->label('Update')
                ->action(function (DepartmentModel $record, array $data): void {
                        
                    $record->name = $data['name'];
                    $record->campus_id = $data['campus_id'];
                    $record->save();
                    $record->generateSlug();
                    

                    // $this->showSuccess('Department Updated', 'Department was successfully updated');
                    Notification::make() 
                    ->title('Saved successfully')
                    ->success()
                    ->send(); 
                    
                })
                ->mountUsing(fn (Forms\ComponentContainer $form, DepartmentModel $record) => $form->fill([
                    'name' => $record->name,
                    'campus_id' => $record->campus->id ?? null,
                ]))
                ->form([
                    Select::make('campus_id')
                    ->label('Choose Campus')
                    ->options(Campus::all()->pluck('name','id'))->searchable(),

                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->required()  
                ])->button()  ->modalHeading('Update Department'),
    
                   DeleteAction::make('Delete')->button()->label('Delete'),

            ]),

         

        ];
    }

    public function showSuccess($header ='Data saved', $content="Your data was successfully save"){
       
        $this->dialog()->success(

            $title = $header,

            $description = $content

        );
       
    }

    protected function getTableHeaderActions(): array
    {
        return [

            Action::make('Import ')
            ->icon('heroicon-o-cloud-upload')
            ->action(function (array $data): void {

            $file  = Storage::disk('public')->path($data['file']);
           
            Excel::import(new DepartmentImport, $file);

            if (Storage::disk('public')->exists($data['file'])) {

                Storage::disk('public')->delete($data['file']);
            }

            Notification::make() 
            ->title('Imported successfully')
            ->success()
            ->send(); 

            
        })->icon('heroicon-o-save')->form([
            FileUpload::make('file')->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/csv', 'text/csv', 'text/plain'])->disk('public')->directory('imports')->label('Excel File'),
        ]) ->modalHeading('Notice')
        ->modalSubheading("Please ensure that the file you are importing is in the correct format. You can download the file from the table menu. It is important to note that existing names will be ignored during the data import process into the system"),
            Tables\Actions\ActionGroup::make([

               
            Action::make('download')->icon('heroicon-s-download')->label('Download Template ')
            ->action(function(){

                // return Excel::download(new CampusExport, 'campus_template.xlsx');
                return Excel::download(new DepartmentExport, 'department_template.xlsx');
            })
            ->requiresConfirmation()
            ->modalHeading('Notice')
            ->modalSubheading("This template is an Excel data file that contains the correct structure for importing campuses. Please refrain from altering the file's structure. Only add your data following the provided examples. It's important to note that modifying the structure may result in errors when importing the data into the system.")
            ->modalButton('Ok, Download'),
               
                
            ]),

            Action::make('create')->button()->icon('heroicon-s-plus')->label('Create New Department')->action(function($data){
                // dd($data);
                $department = DepartmentModel::create([
                    'campus_id'=> $data['campus_id'],
                    'name' => $data['name']
                ]);
                $department->generateSlug();
                // $this->showSuccess('Department Created', 'Department was successfully created');
                Notification::make() 
                ->title('Saved successfully')
                ->success()
                ->send(); 
                

            })->form([
                Select::make('campus_id')
                ->label('Choose Campus')
                ->options(Campus::all()->pluck('name','id'))->searchable(),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->unique()
                    ->required(),
            ])->modalHeading('Create Department'),
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
        return view('livewire.manage.department');
    }
}
