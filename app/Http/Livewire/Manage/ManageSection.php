<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use App\Models\Section;

use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
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
            Tables\Columns\TextColumn::make('course.name')->sortable()->searchable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    
    protected function getTableHeaderActions(): array
    {
        return [
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
                    'course_id' => $record->course->id,
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
