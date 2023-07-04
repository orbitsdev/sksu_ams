<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Contracts\Database\Query\Builder;

class ManageCourse extends Component implements HasTable , HasForms 
{

    use Tables\Concerns\InteractsWithTable; 
    
    use Forms\Concerns\InteractsWithForms; 


    protected function getTableQuery(): Builder 
    {
        return Course::query();
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
                ->action(function (Course $record, array $data): void {
                        
                    $record->name = $data['name'];
                    $record->save();
                 
                })
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('name')
                        ->required(),
                ])->button()  ->modalHeading('Update Course'),
    
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
        return view('livewire.manage.manage-course');
    }
}
