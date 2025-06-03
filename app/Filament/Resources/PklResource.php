<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PklResource\Pages;
use App\Filament\Resources\PklResource\RelationManagers;
use App\Models\Pkl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PklResource extends Resource
{
    protected static ?string $model = Pkl::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('siswa_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('industri_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('guru_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('industri.nama')
                    ->label('Nama Industri')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guru.nama')
                    ->label('Nama Guru')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPkls::route('/'),
            'create' => Pages\CreatePkl::route('/create'),
            'edit' => Pages\EditPkl::route('/{record}/edit'),
        ];
    }
}
