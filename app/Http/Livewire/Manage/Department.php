<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Campus;
use Livewire\Component;
use WireUi\Traits\Actions;
use Forms\ComponentContainer;
use Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Department as DepartmentModel;

use Filament\Notifications\Notification; 
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
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('campus.name')->label('Campus')->sortable()->searchable(),
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
                    $record->save();
                    $record->generateSlug();

                    // $this->showSuccess('Department Updated', 'Department was successfully updated');
                    Notification::make() 
                    ->title('Saved successfully')
                    ->success()
                    ->send(); 
                    
                })
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
