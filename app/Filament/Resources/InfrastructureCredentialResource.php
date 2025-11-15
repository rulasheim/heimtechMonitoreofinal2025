<?php

namespace App\Filament\Resources;

use App\Models\InfrastructureCredential;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Filament\Resources\InfrastructureCredentialResource\Pages;

class InfrastructureCredentialResource extends Resource
{
    protected static ?string $model = InfrastructureCredential::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'Accesos de Infraestructura';
    protected static ?string $pluralModelLabel = 'Accesos';
    protected static ?string $modelLabel = 'Acceso';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nombre del acceso')
                ->required(),

            Forms\Components\Select::make('type')
                ->label('Tipo')
                ->options([
                    'server'     => 'Servidor',
                    'firewall'   => 'Firewall',
                    'switch'     => 'Switch/Router',
                    'wifi'       => 'Controladora WiFi',
                    'database'   => 'Base de datos',
                    'application'=> 'Aplicación',
                    'other'      => 'Otro',
                ])
                ->required(),

            Forms\Components\TextInput::make('host')
                ->label('IP o Dominio')
                ->placeholder('192.168.1.1 o host.midominio.com'),

            Forms\Components\TextInput::make('username')
                ->label('Usuario')
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label('Contraseña')
                    ->revealable() // 👈 Permite mostrar/ocultar la contraseña

                ->password()
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Descripción')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Acceso')->searchable(),

            Tables\Columns\BadgeColumn::make('type')
                ->label('Tipo')
                ->colors([
                    'primary' => 'server',
                    'success' => 'firewall',
                    'warning' => 'switch',
                    'info'    => 'application',
                    'gray'    => 'other',
                ]),

            Tables\Columns\TextColumn::make('host')->label('Host'),

            Tables\Columns\TextColumn::make('username')->label('Usuario'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Creado')
                ->dateTime('d/m/Y'),
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
            'index' => Pages\ListInfrastructureCredentials::route('/'),
            'create' => Pages\CreateInfrastructureCredential::route('/create'),
            'edit' => Pages\EditInfrastructureCredential::route('/{record}/edit'),
        ];
    }
}
