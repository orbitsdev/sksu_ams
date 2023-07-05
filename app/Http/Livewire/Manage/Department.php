<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Forms\ComponentContainer;
use Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Department as DepartmentModel;
use WireUi\Traits\Actions;

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

                    $this->showSuccess('Department Updated', 'Department was successfully updated');
                })
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->required(),
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
            Action::make('create')->button()->icon('heroicon-s-plus')->label('Create New')->action(function($data){
                // dd($data);

                DepartmentModel::create(['name'=> $data['name']]);
                $this->showSuccess('Department Created', 'Department was successfully created');

            })->form([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
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
