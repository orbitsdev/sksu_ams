<?php

namespace App\Http\Livewire\Manage;

use Filament\Tables;
use Livewire\Component;
use Forms\ComponentContainer;
use Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Department as DepartmentModel;
use Filament\Tables\Actions\Modal\Actions\Action;
use Filament\Forms;


class Department extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms
{

    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;

    protected function getTableQuery(): Builder
    {
        return DepartmentModel::query();
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
                })
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('name')
                        ->required(),
                ])->button()  ->modalHeading('Update Department'),
    
                   DeleteAction::make('Delete')->button()->label('Delete'),

            ]),

         

        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }


    public function render()
    {
        return view('livewire.manage.department');
    }
}
