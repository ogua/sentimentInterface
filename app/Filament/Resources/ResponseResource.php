<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Response;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ResponseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResponseResource\RelationManagers;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\TextInput::make('user_id')
                    ->maxLength(36)
                    ->default(null),
                Forms\Components\DateTimePicker::make('submitted_at'),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('device_info')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl('')
            ->columns([
                Tables\Columns\TextColumn::make('survey.title')
                ->label('Survey')
                ->badge()
                ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('IP Address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_info')
                    ->searchable(),
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
            'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }
}
