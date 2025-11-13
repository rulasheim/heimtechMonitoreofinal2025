<?php

namespace App\Filament\Resources;

use App\Models\MonitorTarget;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Filament\Resources\MonitorTargetResource\Pages;

class MonitorTargetResource extends Resource
{
    protected static ?string $model = MonitorTarget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';
    protected static ?string $navigationLabel = 'Monitoreo';
    protected static ?string $pluralModelLabel = 'Hosts Monitoreados';
    protected static ?string $modelLabel = 'Host';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nombre del Host')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('host')
                ->label('IP o DNS')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('host')
                ->label('Host')
                ->searchable(),

            Tables\Columns\IconColumn::make('is_online')
                ->label('Estado')
                ->boolean() // muestra ✔ o ✖
                ->trueColor('success')
                ->falseColor('danger'),

            Tables\Columns\TextColumn::make('latency')
                ->label('Latencia')
                ->formatStateUsing(fn ($state) =>
                    $state ? "{$state} ms" : 'N/A'
                )
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Actualizado')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMonitorTargets::route('/'),
            'create' => Pages\CreateMonitorTarget::route('/create'),
            'edit'   => Pages\EditMonitorTarget::route('/{record}/edit'),
        ];
    }
}
