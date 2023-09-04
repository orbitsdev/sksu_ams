<?php

namespace App\Http\Livewire\Manage;

use Closure;

use Carbon\Carbon;
use App\Models\Log;
use Filament\Forms;
use App\Models\Role;
use Filament\Tables;
use App\Models\Login;
use Livewire\Component;
use WireUi\Traits\Actions;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;


class ManageLog extends Component implements Tables\Contracts\HasTable, Forms\Contracts\HasForms

{
    use Tables\Concerns\InteractsWithTable;
    use Forms\Concerns\InteractsWithForms;
    use Actions;

    protected function getTableQuery(): Builder
    {

        return Login::query()->whereHas('account');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('account.id_number')->label('ID NUMBER'),

         
            TextColumn::make('account')->label('Name')->formatStateUsing(function ($record) {
                return ucwords($record->account->last_name) . ', ' . ucwords($record->account->middle_name) . ' ' . ucwords($record->first_name);
            })->searchable(query: function (Builder $query, string $search): Builder {
                return $query
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            }),

            // TextColumn::make('log')->label('Department'),
            TextColumn::make('log.role_name')->label('Role')->formatStateUsing(function ($record) {
                if($record->log){
                    return ucwords($record->log->role_name);

                }

                return '';
            }),
            TextColumn::make('log.department_name')->label ('Department')->formatStateUsing(function ($record) {
                if($record->log){
                    return ucwords($record->log->department_name);

                }

                return '';
            }),
            // TextColumn::make('morning_in')->label('Morning In'),
            TextColumn::make('morning_in')->formatStateUsing(function ($record) {
                // return $state ? $state->format('h:i:s A') : 'NONE';


                //  return $state Carbon::parse($item->login->noon_out)->format('h:i:s A')

                if (!empty($record->morning_in)) {
                    // return Carbon::parse($record->morning_in)->diffForHumans();
                    return Carbon::parse($record->morning_in)->format('h:i A');
                } else {

                    if ($record->isToday) {
                        return 'Did Not Login';
                    }

                    return 'NONE';
                }
            }),
            TextColumn::make('morning_out')->formatStateUsing(function ($record) {




                if (!empty($record->morning_out)) {
                    // return Carbon::parse($record->morning_in)->diffForHumans();
                    return Carbon::parse($record->morning_out)->format('h:i A');
                } else {

                    if ($record->isToday) {
                        return 'Did Not Logout';
                    }
                    return 'NONE';
                }
            }),
            TextColumn::make('noon_in')->formatStateUsing(function ($record) {




                if (!empty($record->noon_in)) {
                    // return Carbon::parse($record->morning_in)->diffForHumans();
                    return Carbon::parse($record->noon_in)->format('h:i A');
                } else {

                    if ($record->isToday) {
                        return 'Did Not Login';
                    }
                    return 'NONE';
                }
            }),
            TextColumn::make('noon_out')->formatStateUsing(function ($record) {




                if (!empty($record->noon_out)) {
                    // return Carbon::parse($record->morning_in)->diffForHumans();
                    return Carbon::parse($record->noon_out)->format('h:i A');
                } else {

                    if ($record->isToday) {
                        return 'Did Not Logout';
                    }
                    return 'NONE';
                }
            }),

        ];
    }

    protected function getTableFilters(): array
    {
        return [

            Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from'),
                    Forms\Components\DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                
              
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
        ];
    }




    public function render()
    {
        return view('livewire.manage.manage-log');
    }
}
