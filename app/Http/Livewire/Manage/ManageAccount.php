<?php

namespace App\Http\Livewire\Manage;

use Closure;
use Filament\Forms;
use App\Models\Role;

use App\Models\User;
use Filament\Tables;
use App\Models\Course;
use App\Models\Account;
use App\Models\Section;
use Livewire\Component;
use App\Models\Department;
use App\Models\SchoolYear;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use App\Exports\AccountExport;
use App\Imports\AccountToAddImport;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
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
            TextColumn::make('id')->label('Account ID'),
            ImageColumn::make('profile_path')->disk('public')->height(120)->url(function (Account $record) {
                return Storage::url($record->profile_path);
            })->openUrlInNewTab()->defaultImageUrl(url('/images/placeholder.png')),
            // Tables\Columns\TextColumn::make('slug'),
            TextColumn::make('id_number')->searchable(),
            TextColumn::make('Name')->formatStateUsing(fn (Account $record): string =>  Str::upper($record->first_name. ' '. $record->last_name . ' ,'.$record->middle_name ) )    ->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            }),
            TextColumn::make('role.name')->formatStateUsing(fn (null|string $state): string =>  $state ? Str::ucfirst($state) : ''),
            TextColumn::make('department.name')->formatStateUsing(fn (null|string $state): string => $state ? Str::ucfirst($state): ''),
           
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
                            'section_id' => (int)$data['section'],
                            'profile_path' => $data['profile_path'],
                        ];


                        if($record->guardian){
                          
                            $record->guardian()->update([
                                'first_name' => $data['guardian_first_name'],
                                'last_name' => $data['guardian_last_name'],
                                'phone_number' => $data['guardian_phone_number'],
                            ]);
                        }else{
                         
                            $record->guardian()->create([
                                'first_name' => $data['guardian_first_name'],
                                'last_name' => $data['guardian_last_name'],
                                'phone_number' => $data['guardian_phone_number'],
                            ]);
                        }


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
                                $this->showError('Operation Faild', 'The ID Number you entered already exists');
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
                                'section' => $record->section->id ?? null,
                                'school_year_id' => $record->schoolYear->id ?? null,
                                'id_number' =>  $record->id_number,
                                'first_name' => $record->first_name,
                                'last_name' => $record->last_name,
                                'middle_name' => $record->middle_name,
                                'role' => $record->role_id,
                                'profile_path' => $record->profile_path,
                                'guardian_first_name' => $record->guardian->first_name ?? null,
                                'guardian_last_name' => $record->guardian->last_name ?? null,
                                'guardian_phone_number' => $record->guardian->phone_number ?? null,

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
                                Grid::make(4)
                                ->schema([
                                    TextInput::make('id_number')->label('ID Number')->required()->columnSpan(3),
                                    Select::make('role')
                                    ->label('Account Role')
                                    ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id')->map(function($name){
                                        return ucfirst($name);
                                    }))
                                    ->reactive()
                                    ->required()
                                    ->columnSpan(1)
                                ]),
                               
                                
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('first_name')->label('First Name')->required(),
                                        TextInput::make('middle_name')->label('Middle Initial')->required(),
                                        TextInput::make('last_name')->label('Last Name')->required(),
                                    ]),
                                  
                                ]),
                                
                                Fieldset::make('Univeristy Details')->schema([
                              
                                        Grid::make(4)->schema([
    
                                            Select::make('school_year_id')
                                            ->label('School year')
                                            ->options(  SchoolYear::query()
                                            ->latest()
                                            ->get(['id', 'from', 'to'])
                                            ->mapWithKeys(fn ($schoolYear) => [$schoolYear->id => $schoolYear->from . ' - ' . $schoolYear->to])
                                            ->all())
                                            ->required()
                                            ->searchable()
                                            
                                            ->columnSpan(4),
                                        
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
                                            ->columnSpan(fn (Closure $get) => (int)$get('role') === 1 ? 4: 4),
                                          
                                           
    
                                   
                                      
                                            
    
                                       Select::make('course')
                                            ->label('Course')
                                            ->options(function ($get) {
                                                return Course::query()->where('department_id', $get('department'))->pluck('name', 'id');
                                            })
                                            ->required()
                                            ->searchable()
                                            ->reactive()
                                            ->afterStateUpdated(function (Closure $set, $state, $get) {
                                                $section =Section::query()
                                                    ->where('course_id', $state)
                                                    ->first(['name', 'id']);    
                                                if (!empty($section)) {
                                                    $set('section',   $section->id);
                                                }
                                            })
                                            ->columnSpan(4)
                                            ->hidden(fn (Closure $get) => (int)$get('role') === 1)
                                            ,
                                            Select::make('section')
                                                 ->label('Section')
                                                 ->options(function ($get) {
                                                    return Section::query()->where('course_id', $get('course'))->pluck('name', 'id');
                                                 })
                                                 ->required()
                                                 ->searchable()
                                                 ->reactive()
                                                 ->columnSpan(4)
                                                 ->hidden(fn (Closure $get) => (int)$get('role') === 1)
    
    
                       
        
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
            Action::make('Import To Add ')
            ->icon('heroicon-o-cloud-upload')
            ->action(function (array $data): void {

                $file  = Storage::disk('public')->path($data['file']);
           
                Excel::import(new AccountToAddImport, $file);
    
                if (Storage::disk('public')->exists($data['file'])) {
    
                    Storage::disk('public')->delete($data['file']);
    
                }
        })->icon('heroicon-o-save')->form([
            FileUpload::make('file')->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/csv', 'text/csv', 'text/plain'])->disk('public')->directory('imports')->label('Excel File'),
        ])
         ->modalHeading('Import To Update')
         ->modalSubheading('The system is case sensitive, Make Sure the data that you put int the excel is exist in the system as well as the spelling is correct ')
         ->modalSubheading('Are you sure you\'d like to delete these posts? This cannot be undone.')
         ,
            Action::make('Import for update')
            ->icon('heroicon-o-cloud-upload')
            ->action(function (array $data): void {

            // $file  = Storage::disk('public')->path($data['file']);
           
            // Excel::import(new AccountToAddImport, $file);

            // if (Storage::disk('public')->exists($data['file'])) {

            //     Storage::disk('public')->delete($data['file']);

            // }
            
        })->icon('heroicon-o-save')->form([
            FileUpload::make('file')->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/csv', 'text/csv', 'text/plain'])->disk('public')->directory('imports')->label('Excel File'),
        ]) ->modalHeading('Notice'),
            Action::make('download')->icon('heroicon-s-download')->label('Download Template ')
            ->action(function(){

                return Excel::download(new AccountExport, 'accounts.xlsx');
                // return Excel::download(new CampusExport, 'campus_template.xlsx');
            })
            ->requiresConfirmation()
            ->outlined()
            ->modalHeading('Notice')
            ->modalSubheading("When importing accounts, it is crucial to adhere to the provided examples and add your data accordingly. Please ensure that the names you assign to members already exist in the database, such as (campus, department, course, section). Be mindful that the names are case-sensitive, so double-check for proper capitalization and spelling.

            Keep in mind that attempting to assign names to campuses, departments, or sections that do not exist will not be saved. Moreover, modifying the structure could lead to errors when importing the data into the system.
            
            If you have any questions or need assistance, feel free to reach out. We're here to help!")
            ->modalButton('Download'),
               
                
            // Tables\Actions\ActionGroup::make([

               
              
            //     ]),
    

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
                            'section_id' => (int)$data['section'],
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
                            Grid::make(4)
                            ->schema([
                                TextInput::make('id_number')->label('ID Number')->unique()->required()->columnSpan(3),
                                Select::make('role')
                                ->label('Account Role')
                                ->options(Role::query()->where('name', '!=', 'admin')->pluck('name', 'id')->map(function($name){
                                    return ucfirst($name);
                                }))
                                ->reactive()
                                ->required()
                                ->columnSpan(1)
                            ]),
                           
                            
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('first_name')->label('First Name')->required(),
                                    TextInput::make('middle_name')->label('Middle Initial')->required(),
                                    TextInput::make('last_name')->label('Last Name')->required(),
                                ]),
                              
                            ]),
                            
                            Fieldset::make('Univeristy Details')->schema([
                          
                                    Grid::make(4)->schema([

                                        Select::make('school_year_id')
                                        ->label('School year')
                                        ->options(  SchoolYear::query()
                                        ->latest()
                                        ->get(['id', 'from', 'to'])
                                        ->mapWithKeys(fn ($schoolYear) => [$schoolYear->id => $schoolYear->from . ' - ' . $schoolYear->to])
                                        ->all())
                                        ->required()
                                        ->searchable()
                                        
                                        ->columnSpan(4),
                                    
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
                                        ->columnSpan(fn (Closure $get) => (int)$get('role') === 1 ? 4: 4),
                                      
                                       

                               
                                  
                                        

                                   Select::make('course')
                                        ->label('Course')
                                        ->options(function ($get) {
                                            return Course::query()->where('department_id', $get('department'))->pluck('name', 'id');
                                        })
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->afterStateUpdated(function (Closure $set, $state, $get) {
                                            $section =Section::query()
                                                ->where('course_id', $state)
                                                ->first(['name', 'id']);    
                                            if (!empty($section)) {
                                                $set('section',   $section->id);
                                            }
                                        })
                                        ->columnSpan(4)
                                        ->hidden(fn (Closure $get) => (int)$get('role') === 1)
                                        ,
                                        Select::make('section')
                                             ->label('Section')
                                             ->options(function ($get) {
                                                return Section::query()->where('course_id', $get('course'))->pluck('name', 'id');
                                             })
                                             ->required()
                                             ->searchable()
                                             ->reactive()
                                             ->columnSpan(4)
                                             ->hidden(fn (Closure $get) => (int)$get('role') === 1)


                   
    
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
