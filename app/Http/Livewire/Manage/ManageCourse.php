<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Livewire\Component;
use App\Models\Department;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Contracts\Database\Query\Builder;
use WireUi\Traits\Actions;

class ManageCourse extends Component implements HasTable , HasForms 
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
        return Course::query()->latest();
    } 

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('department.name')->sortable()->searchable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    
    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('create')->button()->icon('heroicon-s-plus')->label('Create New Course')->action(function($data){
                // dd($data);

                Course::create([
                    'name'=> $data['name'],
                    'department_id'=> $data['department'],
                ]);

                $this->showSuccess('Course Saved', 'Course was successfully created');


            })->form([
                Forms\Components\Select::make('department')
                ->label('Choose Department')
                ->options(Department::query()->pluck('name', 'id'))->required()->searchable(),  
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
                ->action(function (Course $record, array $data): void {
                        
                    $record->name = $data['name'];
                    $record->department_id = $data['department'];
                    $record->save();   
                    $this->showSuccess('Course Saved', 'Course was successfully updated');
                 
                })
                ->mountUsing(fn (Forms\ComponentContainer $form, Course $record) => $form->fill([
                    'name' => $record->name,
                    'department' => $record->department->id,
                ]))
                ->form([
                    Forms\Components\TextInput::make('name')->label('name')->required(),
                    // Forms\Components\TextInput::make('department')->label('Current Department')->disabled(),
                    Forms\Components\Select::make('department')
                    ->label('Choose New Department')
                    ->options(Department::query()->pluck('name', 'id'))->required()->searchable(),  

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
        return view('livewire.manage.manage-course');
    }
}
