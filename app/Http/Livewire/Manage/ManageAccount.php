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
use App\Models\SchoolYear;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Fieldset;
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


    public function showSuccess($header = 'Data saved', $content = "Your data was successfully save")
    {

        $this->dialog()->success(

            $title = $header,

            $description = $content

        );
    }

    public function showError($header = 'Data saved', $content = "Your data was successfully save")
    {

        $this->dialog()->error(

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
            })->openUrlInNewTab()->defaultImageUrl(url('/images/placeholder.png')),
            // Tables\Columns\TextColumn::make('slug'),
            TextColumn::make('id_number')->searchable(),
            TextColumn::make('Name')->formatStateUsing(fn (Account $record): string => Str::upper($record->first_name. ' '. $record->last_name . ' ,'.$record->middle_name ) )    ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            }),
            TextColumn::make('role.name')->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),
            TextColumn::make('department.name')->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),
           
            // TextColumn::make('course.department.name'),
            // TextColumn::make('')->searchable(),
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


                Action::make('View')->icon('heroicon-s-eye')->label('View Profile')
                    ->url(fn (Account $record): string => route('account.details', $record)),

                EditAction::make('edit')->action(function (Account $record, array $data) {
                 
                    if (!empty($data['profile_path']) && $data['profile_path'] != $record->profile_path) {
                        $oldpic = $record->profile_path;
                        $record->update([
                            'profile_path' => $data['profile_path'],
                        ]);

                  
                        
                        if(!empty($oldpic)) {

                            // Assuming $oldpic contains only the file path relative to the public disk (e.g., 'profile/pic.jpg')
                            if (Storage::disk('public')->exists($oldpic)) {
                                
                                Storage::disk('public')->delete($oldpic);
                            }
                        }
                    }
                    
                    if ((int)$data['role'] != 1) {
                        $accountdata = [
                            
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'middle_name' => $data['middle_name'],
                            'role_id' => (int)$data['role'],
                            'department_id' => (int)$data['department'],
                            'school_year_id' => (int)$data['school_year_id'],
                            'course_id' => (int)$data['course'],
                            'profile_path' => $data['profile_path'],
                        ];

                        $record->guardian()->update([
                            'first_name' => $data['guardian_first_name'],
                            'last_name' => $data['guardian_last_name'],
                            'phone_number' => $data['guardian_phone_number'],
                        ]);

                        // $course = Course::where('department_id', $data['department'])->first();
                        
                        // if ($course) {
                        //     // If the course is found, update the attributes directly.
                        //     $course->update(['id' => (int)$data['course'] ]);
                        // }
                       
                        
                    } else {
                        $accountdata = [
                            
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'middle_name' => $data['middle_name'],
                            'role_id' => (int)$data['role'],
                            'department_id' => (int)$data['department'],
                            'school_year_id' => (int)$data['school_year_id'],
                            'profile_path' => $data['profile_path'],
                        ];
                    }
                    
                    if ($record) {
                        
                        if($record->id_number != $data['id_number']){
                            $accountdata['id_number'] = $data['id_number'];
                            if(Account::where('id_number', $data['id_number'])->exists()){
                                $this->showError('ID Number Exists', 'The ID Number you entered already exists');
                                return;
                            }
                        }
                        
                        $record->update($accountdata);
                        $this->showSuccess('Account Updated', 'Account was successfully updated');
                    } else {


                        // Handle the case where the account data is not valid or missing.
                        // You can show an error message or take appropriate action.
                    }
                    
                    
                })
                    ->label('Update')
                    ->mountUsing(
                        function (Forms\ComponentContainer $form, Account $record) {
                                                        
                            
                            if($record->role_id != 1){
                           
                            $form->fill([
                                'department' => $record->department_id ?? null,
                                'course' => $record->course->id ?? null,
                                'school_year_id' => $record->schoolYear->id ?? null,
                                'id_number' =>  $record->id_number,
                                'first_name' => $record->first_name,
                                'last_name' => $record->last_name,
                                'middle_name' => $record->middle_name,
                                'role' => $record->role_id,
                                'profile_path' => $record->profile_path,
                                'guardian_first_name' => $record->guardian->first_name,
                                'guardian_last_name' => $record->guardian->last_name,
                                'guardian_phone_number' => $record->guardian->phone_number,

                            ]);
                            }else{  

                                $form->fill([
                                    'department' => $record->department_id ?? null,
                                    'school_year_id' => $record->schoolYear->id ?? null,
                                    'id_number' =>  $record->id_number,
                                    'first_name' => $record->first_name,
                                    'last_name' => $record->last_name,
                                    'middle_name' => $record->middle_name,
                                    'role' => $record->role_id,
                                    'profile_path' => $record->profile_path,
                                ]);

                            }


                        }
                    )
                    ->form([
                        FileUpload::make('profile_path')
                        ->image()
                        ->disk('public')
                        ->label('Profile Photo')
                        ->directory('user-profile')
                        ->columnSpan(2)->avatar(),
    
                        Fieldset::make('Member Details')
                            ->schema([
    
                                TextInput::make('id_number')->label('ID Number')->required()->columnSpan(2),
    
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('first_name')->label('First Name')->required(),
                                        TextInput::make('middle_name')->label('Middle Initial')->required(),
                                        TextInput::make('last_name')->label('Last Name')->required(),
                                    ]),
                             
                                ]),
                                Fieldset::make('Univeristy Details')->schema([
                              
                                        Grid::make(3)->schema([
                                            
                                            Select::make('school_year_id')
                                            ->label('School year')
                                            ->options(
                                                SchoolYear::query()
                                                ->latest()
                                                ->get(['id', 'from', 'to'])
                                                ->mapWithKeys(fn ($schoolYear) => [$schoolYear->id => $schoolYear->from . ' - ' . $schoolYear->to])
                                                ->all()
                                            )
                                            ->required()
                                            ->searchable()
                                            ->columnSpan(3),
                                            Select::make('role')
                                            ->label('Account Role')
                                            ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id')->map(function($name){
                                                return ucfirst($name);
                                            }))
                                            ->reactive()
                                            ->required(),
                                           
    
                                       Select::make('department')
                                            ->label('Department')
                                            ->options(Department::query()->pluck('name', 'id'))
                                            ->required()
                                            ->searchable()
                                            ->reactive()
                                            ->afterStateUpdated(function (Closure $set, $state, $get) {
                                                $course = Course::query()
                                                    ->where('department_id', $state)
                                                    ->first(['name', 'id']);    
                                                if (!empty($course)) {
                                                    $set('course',   $course->id);
                                                }
                                            })
                                            ->columnSpan(fn (Closure $get) => (int)$get('role') === 1 ? 2: 1),
                                            
    
                                       Select::make('course')
                                            ->label('Course')
                                            ->options(function ($get) {
                                                return Course::query()->where('department_id', $get('department'))->pluck('name', 'id');
                                            })
                                            ->required()
                                            ->searchable()
                                            ->reactive()
                                            ->hidden(fn (Closure $get) => (int)$get('role') === 1)
                                            ,
    
                       
        
                            ]),
        
                        ]),
                                
                       
                                Fieldset::make('Guardian Details')
                                ->schema([
                                    Grid::make(3)
                                    ->schema([
                                        TextInput::make('guardian_first_name')->label('First Name')->required(),
                                        TextInput::make('guardian_last_name')->label('Last Name')->required(),
                                        TextInput::make('guardian_phone_number')->label('Phone Number')->required(),
                                    ]),
                                ])->hidden(fn (Closure $get) => (int)$get('role') === 1),
    

                    ]),
                DeleteAction::make('Delete')->button()->label('Delete')->before(function (Account $record) {
                    if(!empty($record->profile_path) ){

                        if (Storage::disk('public')->exists($record->profile_path ?? '')) {
                            
                            Storage::disk('public')->delete($record->profile_path);
                        }
                        $record->delete();
                    }
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
                ->label('Create New Member')
                ->icon('heroicon-s-plus')

                ->action(function (array $data): void {
                  
                    if((int)$data['role'] != 1){
                         
                        $accountdata = [
                            'id_number' => $data['id_number'],
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'middle_name' => $data['middle_name'],
                            'role_id' => (int)$data['role'],
                            'school_year_id' => (int)$data['school_year_id'],
                            'department_id' => (int)$data['department'],
                            'course_id' => (int)$data['course'],
                            'profile_path' => $data['profile_path'],
                        ];

                        $new_account =   Account::create($accountdata);
                        $guarddian =  $new_account->guardian()->create([
                            'first_name' => $data['guardian_first_name'],
                            'last_name' => $data['guardian_last_name'],
                            'phone_number' => $data['guardian_phone_number'],
                        ]);
                        
                    }else{
                        $accountdata = [
                            'id_number' => $data['id_number'],
                            'first_name' => $data['first_name'],
                            'last_name' => $data['last_name'],
                            'middle_name' => $data['middle_name'],

                            'role_id' => (int)$data['role'],
                            'department_id' => (int)$data['department'],
                            'school_year_id' => (int)$data['school_year_id'],
                            'profile_path' => $data['profile_path'],
                        ];
                        
                        
                        $new_account =   Account::create($accountdata);

                    
                    }
                   
                    

                    $this->showSuccess('Account Saved', 'Account was successfully created');
                })
                ->form([

                    FileUpload::make('profile_path')
                    ->image()
                    ->disk('public')
                    ->label('Profile Photo')
                    ->directory('user-profile')
                    ->columnSpan(2)->avatar(),

                    Fieldset::make('Member Details')
                        ->schema([

                            TextInput::make('id_number')->label('ID Number')->unique()->required()->columnSpan(2),

                            Grid::make(3)
                                ->schema([
                                    TextInput::make('first_name')->label('First Name')->required(),
                                    TextInput::make('middle_name')->label('Middle Initial')->required(),
                                    TextInput::make('last_name')->label('Last Name')->required(),
                                ]),
                         
                            ]),
                            Fieldset::make('Univeristy Details')->schema([
                          
                                    Grid::make(3)->schema([

                                        Select::make('school_year_id')
                                        ->label('School year')
                                        ->options(  SchoolYear::query()
                                        ->latest()
                                        ->get(['id', 'from', 'to'])
                                        ->mapWithKeys(fn ($schoolYear) => [$schoolYear->id => $schoolYear->from . ' - ' . $schoolYear->to])
                                        ->all())
                                        ->required()
                                        ->searchable()
                                        
                                        ->columnSpan(3),
                                        Select::make('role')
                                        ->label('Account Role')
                                        ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id')->map(function($name){
                                            return ucfirst($name);
                                        }))
                                        ->reactive()
                                        ->required(),
                                       

                               
                                   Select::make('department')
                                        ->label('Department')
                                        ->options(Department::query()->pluck('name', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->afterStateUpdated(function (Closure $set, $state, $get) {
                                            $course = Course::query()
                                                ->where('department_id', $state)
                                                ->first(['name', 'id']);    
                                            if (!empty($course)) {
                                                $set('course',   $course->id);
                                            }
                                        })
                                        ->columnSpan(fn (Closure $get) => (int)$get('role') === 1 ? 2: 1),
                                        

                                   Select::make('course')
                                        ->label('Course')
                                        ->options(function ($get) {
                                            return Course::query()->where('department_id', $get('department'))->pluck('name', 'id');
                                        })
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->hidden(fn (Closure $get) => (int)$get('role') === 1)
                                        ,

                   
    
                        ]),
    
                    ]),
                            
                   
                            Fieldset::make('Guardian Details')
                            ->schema([
                                Grid::make(3)
                                ->schema([
                                    TextInput::make('guardian_first_name')->label('First Name'),
                                    TextInput::make('guardian_last_name')->label('Last Name'),
                                    TextInput::make('guardian_phone_number')->label('Phone Number'),
                                ]),
                            ])->hidden(fn (Closure $get) => (int)$get('role') === 1),


                        ])
                ->button()
                ->modalHeading('Create new member'),

        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make()->before(function (Collection $records) {

                foreach ($records as $record) {
                    if(!empty($record->profile_path) ){

                        if (Storage::disk('public')->exists($record->profile_path ?? '')) {
    
                            Storage::disk('public')->delete($record->profile_path);
                        }
                        $record->delete();
                    }
                
                }
            }),

        ];
    }


    public function render()
    {
        return view('livewire.manage.manage-account');
    }
}
