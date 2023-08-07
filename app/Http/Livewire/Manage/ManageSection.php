<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use App\Models\Section;

use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Imports\SectionImport;
use App\Exports\SectionsExport;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification; 
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Contracts\Database\Query\Builder;

class ManageSection extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms
{

    use Tables\Concerns\InteractsWithTable; 
    
    use Forms\Concerns\InteractsWithForms; 
    use Actions;


  
    public function showSuccess($header ='Data saved', $content="Your data was successfully save"){
       
        $this->dialog()->success(

            $title = $header,

            $description = $content

        );
       
    }


    protected function getTableQuery(): Builder 
    {
        return Section::query()->latest();
    } 

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('course.name')->sortable()
            ->formatStateUsing(fn ($state): string => $state ? $state : 'N/A' )
            ->searchable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    
    protected function getTableHeaderActions(): array
    {
        return [

            Action::make('Import ')
            ->icon('heroicon-o-cloud-upload')
            ->action(function (array $data): void {

            $file  = Storage::disk('public')->path($data['file']);
           
            Excel::import(new SectionImport, $file);

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
                return Excel::download(new SectionsExport, 'sections_template.xlsx');
            })
            ->requiresConfirmation()
            ->modalHeading('Notice')
            ->modalSubheading("This template is an Excel data file that contains the correct structure for importing campuses. Please refrain from altering the file's structure. Only add your data following the provided examples. It's important to note that modifying the structure may result in errors when importing the data into the system.")
            ->modalButton('Ok, Download'),
               
                
            ]),
            Action::make('create')->button()->icon('heroicon-s-plus')->label('Create New Section')->action(function($data){
                // dd($data);

                Section::create([
                    'name'=> $data['name'],
                    'course_id'=> $data['course_id'],
                ]);

                // $this->showSuccess('Course Saved', 'Course was successfully created');
                Notification::make() 
                ->title('Saved successfully')
                ->success()
                ->send(); 


            })->form([
                Forms\Components\Select::make('course_id')
                ->label('Choose Course')
                ->options(
                    Department::query()->pluck('name', 'id')->map(function ($name) {
                        return ucwords($name);
                    })
                )->required()->searchable(),
                // Forms\Components\Select::make('department')
                // ->label('Choose Department')
                // ->options(Department::query()->pluck('name', 'id'))->required()->searchable(),  
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->unique()
                    ->required(),
                  
            ])->modalHeading('Create Course'),
        ];
    }
    protected function getTableActions(): array
    {
        return [

            Tables\Actions\ActionGroup::make([

                EditAction::make('update')->label('Update')
                ->action(function (Section $record, array $data): void {
                        
                    $record->name = $data['name'];
                    $record->course_id = $data['course_id'];
                    $record->save();   
                    // $this->showSuccess('Course Saved', 'Course was successfully updated');
                    Notification::make() 
                    ->title('Update successfully')
                    ->success()
                    ->send(); 
    
                 
                })
                ->mountUsing(fn (Forms\ComponentContainer $form, Section $record) => $form->fill([
                    'name' => $record->name,
                    'course_id' => $record->course->id ?? null,
                ]))
                ->form([
                    Select::make('course_id')
                    ->label('Choose Course')
                    ->options(Course::all()->pluck('name','id'))->searchable(),
                    Forms\Components\TextInput::make('name')->label('name')->required(),
                    // Forms\Components\TextInput::make('department')->label('Current Department')->disabled(),
                   

                ])->button()  ->modalHeading('Update Course'),
    
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
        return view('livewire.manage.manage-section');
    }


}
