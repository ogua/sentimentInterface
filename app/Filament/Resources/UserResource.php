<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    protected static ?int $navigationSort = 99;
    
    protected static ?string $navigationGroup = 'Settings';
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('')
            ->description('')
            ->schema([
                
                Forms\Components\FileUpload::make('avatar_url')
                ->image()
                ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

                //Forms\Components\DateTimePicker::make('email_verified_at'),
                
                Forms\Components\TextInput::make('password')
                ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
                ->password()
                ->revealable(filament()->arePasswordsRevealable())
                ->rule(Password::default())
                ->autocomplete('new-password')
                ->dehydrated(fn($state): bool => filled($state))
                ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                ->live(debounce: 500)
                ->same('passwordConfirmation'),
                
                Forms\Components\TextInput::make('passwordConfirmation')
                ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
                ->password()
                ->revealable(filament()->arePasswordsRevealable())
                ->required()
                ->visible(fn($get): bool => filled($get('password')))
                ->dehydrated(false),
                
                // Forms\Components\TextInput::make('role')
                // ->required(),
                
                ])
                ->columns(2),
            ]);
        }
        
        public static function table(Table $table): Table
        {
            return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url'),
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                
                //Tables\Columns\TextColumn::make('role'),
                
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
                            'index' => Pages\ListUsers::route('/'),
                            'create' => Pages\CreateUser::route('/create'),
                            'edit' => Pages\EditUser::route('/{record}/edit'),
                        ];
                    }
                }
                