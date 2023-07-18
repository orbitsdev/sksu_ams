<?php

namespace App\Http\Livewire\Manage;

use Filament\Forms;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use App\Models\Account;

use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;

use Filament\Notifications\Notification; 

class ManageUser extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms
{

    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;

    protected function getTableQuery(): Builder
    {
        return User::where('id', '!=', Auth::user()->id)->latest();
        // return User::query()->wherewhereHas('roles', function ($query) {
        //     $query->where('name', '!=', 'admin');
        // });
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('slug'),
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('roles.name')->formatStateUsing(fn (null|string $state): null|string => empty($state) ? '' : ucwords($state)),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('create')->button()->icon('heroicon-s-plus')->label('Create New Account')->action(function ($data) {

                $role = Role::find($data['role']);
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'],),
                ]);

                $user->roles()->sync($role->id);

                Notification::make() 
                ->title('Saved successfully')
                ->success()
                ->send();

            })->form([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email address')
                    ->unique()
                    ->required()->email(),
                Forms\Components\TextInput::make('password')
                    ->label('Account password')
                    ->required(),
                Forms\Components\Select::make('role')
                    ->label('Choose role')
                    ->options(
                        Role::query()->pluck('name', 'id')->map(function ($name) {
                            return ucwords($name);
                        })
                    )->required(),

            ])->modalHeading('Create System Account'),
        ];
    }

    protected function getTableActions(): array
    {
        return [

            Tables\Actions\ActionGroup::make([

                EditAction::make('Update')
                    ->button()
                    ->label('Update')

                    ->mountUsing(fn (Forms\ComponentContainer $form, User $record) => $form->fill([
                        'name' => $record->name,
                        'role' => $record->roles->first() ? $record->roles->first()->id : null,

                    ]))
                    ->action(function (User $record, array $data): void {
                        // dd($data['roles']['name']);


                        if (!empty($data['role'])) {


                            if($record->roles->first()){
                                if($data['role'] != $record->roles->first()->id){
                                    $record->roles()->sync($data['role']);
                                }
                            }else{
                                $record->roles()->sync($data['role']);
                            }
                            

                            
                            // if ($data['role'] != $record->role->first()->id) {

                            //     $record->roles()->sync($data['role']);
                            // }
                        }

                        if (!empty($data['password'])) {

                            $record->password = Hash::make($data['password']);
                        }

                        $record->name = $data['name'];
                        $record->save();
                        Notification::make() 
                        ->title('Update Successfully')
                        ->success()
                        ->send();
                    })
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('New Password'),
                        Forms\Components\Select::make('role')
                            ->label('Choose Role')
                            ->options(Role::query()->pluck('name', 'id')->map(function ($name) {
                                return ucwords($name);
                            }),),
                    ])
                    ->button()->modalHeading('Update System Account'),
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
        return view('livewire.manage.manage-user');
    }
}
