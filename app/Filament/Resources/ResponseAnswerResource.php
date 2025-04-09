<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ResponseAnswer;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResponseAnswerResource\Pages;
use App\Filament\Resources\ResponseAnswerResource\RelationManagers;

class ResponseAnswerResource extends Resource
{
    protected static ?string $model = ResponseAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('response_id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\TextInput::make('question_id')
                    ->required()
                    ->maxLength(36),
                Forms\Components\Textarea::make('answer_text')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('surveyResponse.user.name')
                    ->label('Submitted By')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('surveyQuestion.question_text')
                    ->label('Question')
                    ->searchable()
                    ->badge(),

                Tables\Columns\TextColumn::make('answer_text')
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
            'index' => Pages\ListResponseAnswers::route('/'),
            'create' => Pages\CreateResponseAnswer::route('/create'),
            'edit' => Pages\EditResponseAnswer::route('/{record}/edit'),
        ];
    }
}
