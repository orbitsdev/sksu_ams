<?php

namespace App\Http\Livewire\Manage;

use Closure;
use Filament\Forms;
use App\Models\Role;

use App\Models\User;
use Filament\Tables;
use App\Models\Course;
use App\Models\Account;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;


class ManageAccount extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms

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


    public $deparments;
    protected function getTableQuery(): Builder
    {
        // return User::query()->whereHas('roles', function ($query) {
        //     $query->where('name', '!=', 'admin');
        // });

        return Account::query();
    }



    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('profile_path')->disk('public')->height(120)->url(function (Account $record) {
                return Storage::url($record->profile_path);
            })->openUrlInNewTab(),
            // Tables\Columns\TextColumn::make('slug'),
            TextColumn::make('id_number')->searchable(),
            TextColumn::make('first_name')->formatStateUsing(fn (string $state): string => Str::ucfirst($state))->searchable(),
            TextColumn::make('last_name')->formatStateUsing(fn (string $state): string => Str::ucfirst($state))->searchable(),
            TextColumn::make('course.name'),
            TextColumn::make('role.name')->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),
            // TextColumn::make('course.department.name'),
            // TextColumn::make('')->searchable(),
            TextColumn::make('password'),
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

                EditAction::make('edit')->action(function(Account $record, array $data){
                  

                    if(!empty($data['profile_path'])){
                       
                       $oldpic = $record->profile_path;
                        $record->update([
                            'profile_path' => $data['profile_path'],
                        ]);

                        if(Storage::disk('public')->exists($oldpic)){

                            Storage::disk('public')->delete($oldpic);
                        }


                        


                    }

                    $record->update([
                        'id_number' => $data['id_number'],
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'role_id' =>(int)$data['role'],
                        'course_id' => (int)$data['course'],
                        'password' => $data['password'],
                    ]);


                })
                ->label('Update')
                ->mountUsing(function (Forms\ComponentContainer $form, Account $record) {
                    
                    $form->fill([
                        'department' => $record->course->department_id,
                        'id_number' =>  $record->id_number,
                        'first_name' =>$record->first_name, 
                        'last_name' => $record->last_name,
                        'role' => $record->role_id,
                        'course' =>  $record->course_id,
                        'password' =>  $record->password,
                        // 'profile_path' => $record->profile_path,
                    ]);
                }
                )
                ->form([
                    TextInput::make('id_number')->label('ID Number')->required(),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('first_name')->label('First name')->required(),
                            TextInput::make('last_name')->label('Last name')->required(),
                        ]),
                    Forms\Components\Select::make('role')
                        ->label('Account Role')
                        ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id'))->required(),
                    Forms\Components\Select::make('department')
                        ->label('Department')
                        ->options(Department::query()->whereHas('courses')->pluck('name', 'id'))->required()->searchable()->reactive()->afterStateUpdated(function (Closure $set, $state ,$get) {
                            $course = Course::query()
                            ->where('department_id', $state)
                            ->first(['name', 'id']);
                        
                           
                          
                            if(!empty($course)){
                                $set('course',   $course->id);
                            }
                        }),
                    Forms\Components\Select::make('course')
                        ->label('Course')
                        ->options(function($get){
                           return Course::query()->where('department_id', $get('department'))->pluck('name', 'id');
                        })->required()->searchable()->reactive(),
                    TextInput::make('password')->label('Password')->required(),

                    FileUpload::make('profile_path')
                        ->image()
                        ->disk('public')
                        ->label('Profile Photo')
                        ->directory('user-profile') ->maxSize(10240)
                        
                ]),
                DeleteAction::make('Delete')->button()->label('Delete')->before(function (Account $record) {

                    if(Storage::disk('public')->exists($record->profile_path)){

                        Storage::disk('public')->delete($record->profile_path);
                    }
                    $record->delete();
                    $this->showSuccess('Account Deleted', 'Account was successfully deleted');
                }),
            ]),



        ];
    }
    protected function getTableHeaderActions(): array
    {
        return [


            Action::make('Create New')
                ->button()
                ->label('Create New')
                ->icon('heroicon-s-plus')
                
                ->action(function ( array $data): void {
                    $accountdata = [
                        'id_number' => $data['id_number'],
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'role_id' =>(int)$data['role'],
                        'course_id' => (int)$data['course'],
                        'password' => $data['password'],
                        'profile_path' => $data['profile_path'],
                    ];

                  $new_account =   Account::create($accountdata);
                
                    $this->showSuccess('Account Saved', 'Account was successfully created');

                })
                ->form([
                    TextInput::make('id_number')->label('ID Number')->unique()->required(),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('first_name')->label('First name')->required(),
                            TextInput::make('last_name')->label('Last name')->required(),
                        ]),
                    Forms\Components\Select::make('role')
                        ->label('Account Role')
                        ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id'))->required(),
                    Forms\Components\Select::make('department')
                        ->label('Department')
                        ->options(Department::query()->whereHas('courses')->pluck('name', 'id'))->required()->searchable()->reactive()->afterStateUpdated(function (Closure $set, $state ,$get) {
                            $course = Course::query()
                            ->where('department_id', $state)
                            ->first(['name', 'id']);
                        
                           
                          
                            if(!empty($course)){
                                $set('course',   $course->id);
                            }
                        }),
                    Forms\Components\Select::make('course')
                        ->label('Course')
                        ->options(function($get){
                           return Course::query()->where('department_id', $get('department'))->pluck('name', 'id');
                        })->required()->searchable()->reactive(),
                    TextInput::make('password')->label('Password')->required(),

                    FileUpload::make('profile_path')
                        ->image()
                        ->disk('public')
                        ->label('Profile Photo')
                        ->directory('user-profile')
                        ->required()
        
                ])
                ->button()
                ->modalHeading('Create new account'),
        


        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make()->before(function (Collection $records) {
                
                foreach($records as $record){
                    if(Storage::disk('public')->exists($record->profile_path)){

                        Storage::disk('public')->delete($record->profile_path);
                    }
                    $record->delete();
                }
                
            }),
         
        ];
    }


    public function render()
    {
        return view('livewire.manage.manage-account');
    }
}
