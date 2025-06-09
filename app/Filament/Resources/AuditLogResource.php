<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Audit Log';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('table_name')
                    ->label('Tabel')
                    ->disabled(),
                Forms\Components\TextInput::make('record_id')
                    ->label('ID Record')
                    ->disabled(),
                Forms\Components\TextInput::make('action')
                    ->label('Aksi')
                    ->disabled(),
                Forms\Components\KeyValue::make('old_values')
                    ->label('Nilai Lama')
                    ->disabled(),
                Forms\Components\KeyValue::make('new_values')
                    ->label('Nilai Baru')
                    ->disabled(),
                Forms\Components\TextInput::make('user.name')
                    ->label('User')
                    ->disabled(),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Waktu')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('formatted_table_name')
                    ->label('Tabel')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('table_name', 'like', "%{$search}%");
                    }),
                Tables\Columns\TextColumn::make('record_id')
                    ->label('ID Record')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('formatted_action')
                    ->label('Aksi')
                    ->colors([
                        'success' => 'Dibuat',
                        'warning' => 'Diperbarui',
                        'danger' => 'Dihapus',
                    ]),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->default('System'),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('table_name')
                    ->label('Tabel')
                    ->options([
                        'siswas' => 'Siswa',
                        'pkls' => 'PKL',
                        'industris' => 'Industri',
                        'gurus' => 'Guru',
                        'users' => 'User',
                    ]),
                Tables\Filters\SelectFilter::make('action')
                    ->label('Aksi')
                    ->options([
                        'INSERT' => 'Dibuat',
                        'UPDATE' => 'Diperbarui',
                        'DELETE' => 'Dihapus',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
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
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto refresh setiap 30 detik
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
            'view' => Pages\ViewAuditLog::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Tidak bisa create manual
    }

    public static function canEdit($record): bool
    {
        return false; // Tidak bisa edit
    }

    public static function canDelete($record): bool
    {
        return false; // Tidak bisa delete
    }
}