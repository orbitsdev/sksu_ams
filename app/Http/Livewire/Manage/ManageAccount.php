<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use App\Models\Role;
use App\Models\User;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;

class ManageAccount extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms

{
    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;

    protected function getTableQuery(): Builder
    {
        return User::query()->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'admin');
        });
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('email')->sortable()->searchable(),
            TextColumn::make('roles.name')->sortable()->searchable(),
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
          
                Action::make('Update')
                ->button()
                ->label('Update')

                ->mountUsing(fn (Forms\ComponentContainer $form, User $record) => $form->fill([
                    'name' => $record->name,
                    'role' => $record->roles->pluck('name')->toArray(),
                    'roles' => $record->roles->pluck('id')->toArray(),
                ]))
             ->action(function (User $record, array $data): void {
                            // dd($data['roles']['name']);
                            
                            if(!empty($data['roles']['name'])){
                                if($data['roles']['name'] != $record->roles->first()->id){
                                    
                                    $record->roles()->sync($data['roles']['name']);
                                }
                            }



                            $record->name = $data['name'];
                            $record->save();
                        })
                  ->form([
                            TextInput::make('name')->label('Name')->required(),
                            TextInput::make('role')->label('Current Role')->disabled(),
                            Forms\Components\Select::make('roles.name')
                                ->label('Change New Role')
                                ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id')),
                        ])
                ->button()->modalHeading('Update Account'),
                Action::make('Delete')->button()->label('Delete'),
            ]),



        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }


    public function render()
    {
        return view('livewire.manage.manage-account');
    }
}
