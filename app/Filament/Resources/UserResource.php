<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
                
            Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->unique(User::class, 'email') // pastikan email unik
                ->maxLength(255),
                
            Forms\Components\TextInput::make('phone_number')
                ->nullable()
                ->maxLength(255),

                 
            Forms\Components\Select::make('role') // Role sebagai dropdown
            ->required()
            ->options([
                1 => 'Admin',
                2 => 'User',
            ])
            ->default(2), // Default sebagai User

            Forms\Components\TextInput::make('password')
                ->required()
                ->password()
                ->minLength(8), // misalnya minimal 8 karakter untuk password
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->sortable() // untuk memungkinkan urutan berdasarkan nama
                ->searchable(), // untuk memungkinkan pencarian berdasarkan nama

            Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('phone_number')
                ->sortable()
                ->searchable(), // kolom phone_number juga bisa dicari

            Tables\Columns\TextColumn::make('role')
                ->label('Role')
                ->sortable()
                ->formatStateUsing(fn ($state) => $state === 1 ? 'Admin' : 'User'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At') // memberikan label yang lebih jelas
                ->dateTime() // format tanggal dan waktu
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('role')
                    ->options([
                        1 => 'Admin',
                        2 => 'User',
                    ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(), // memungkinkan untuk mengedit data pengguna
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(), // memungkinkan untuk menghapus beberapa data sekaligus
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}