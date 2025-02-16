<?php

namespace App\Filament\Clusters\Users\Resources;

use App\Filament\Clusters\Users;
use App\Filament\Clusters\Users\Resources\CustomerResource\Pages;
use App\Filament\Exports\CustomerExporter;
use App\Models\Customer;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $cluster = Users::class;

    protected static ?string $modelLabel = 'Nasabah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Diri')
                    ->schema([
                        Hidden::make('user_id'),
                        Forms\Components\TextInput::make('nik')
                            ->required()
                            ->numeric()
                            ->maxLength(16)
                            ->minLength(16)
                            ->label('NIK')
                            ->placeholder('Masukkan 16 digit NIK, contoh: 3171066509900001')
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'required' => 'NIK harus diisi.',
                                'numeric' => 'NIK harus berisi angka.',
                                'min_digits' => 'NIK harus berisi 16 digit angka.',
                                'max_digits' => 'NIK berisi maksimal 16 digit angka.',
                                'unique' => 'NIK sudah digunakan.'
                            ]),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Forms\Components\TextInput::make('full_name')
                                ->required()
                                ->placeholder('Masukkan nama lengkap sesuai KTP, contoh: Budi Santoso')
                                ->maxValue(100)
                                ->label('Nama Lengkap')
                                ->validationMessages([
                                    'required' => 'Nama Lengkap harus diisi.',
                                    'max' => 'Nama Lengkap tidak boleh melebihi 100 karakter.'
                                ]),
                            Forms\Components\TextInput::make('place_of_birth')
                                ->required()
                                ->placeholder('Masukkan kota kelahiran, contoh: Surabaya')
                                ->maxValue(50)
                                ->label('Tempat Lahir')
                                ->validationMessages([
                                    'required' => 'Tempat Lahir harus diisi.',
                                    'max' => 'Tempat Lahir tidak boleh melebihi 50 karakter.'
                                ]),
                            Forms\Components\DatePicker::make('date_of_birth')
                                ->required()
                                ->date()
                                ->label('Tanggal Lahir')
                                ->placeholder('Pilih tanggal lahir sesuai KTP')
                                ->validationMessages([
                                    'required' => 'Tanggal Lahir harus diisi.',
                                    'date' => 'Tanggal lahir tidak valid.'
                                ]),
                            Forms\Components\TextInput::make('phone')
                                ->numeric()
                                ->required()
                                ->minLength(9)
                                ->maxLength(14)
                                ->unique(ignoreRecord: true)
                                ->placeholder('Masukkan nomor HP aktif, contoh: 81234567890')
                                ->validationMessages([
                                    'required' => 'Nomor telepon harus diisi.',
                                    'min_digits' => 'Nomor telepon harus berisi setidaknya 9 digit angka.',
                                    'max_digits' => 'Nomor telepon tidak boleh melebihi 14 digit angka.',
                                    'unique' => 'Nomor telepon sudah digunakan.',
                                    'numeric' => 'Nomor telepon tidak valid.'
                                ])
                                ->prefix('+62')
                                ->label('Nomor Telepon'),
                            Forms\Components\FileUpload::make('identity_card_photo')
                                ->label('Foto KTP')
                                ->maxFiles(1024)
                                ->imageEditor()
                                ->directory('identity_card_photos')
                                ->nullable()
                                ->image()
                                ->placeholder('Unggah foto KTP')
                                ->validationMessages([
                                    'max' => 'Ukuran file Foto KTP tidak boleh lebih dari 1024KB.',
                                ]),
                            Forms\Components\FileUpload::make('avatar_url')
                                ->label('Foto Profil')
                                ->maxFiles(1024)
                                ->imageEditor()
                                ->directory('avatars')
                                ->nullable()
                                ->image()
                                ->placeholder('Unggah foto profil')
                                ->validationMessages([
                                    'max' => 'Ukuran file Foto Profil tidak boleh lebih dari 1024KB.',
                                ]),
                        ]),
                    ]),
                Section::make('Alamat Lengkap')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(2000)
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat lengkap, contoh: Jl. Anggrek No. 123, Perumahan Griya Indah Blok A2')
                            ->validationMessages([
                                'required' => 'Alamat harus diisi.',
                                'max' => 'Alamat tidak boleh melebihi 2000 karakter.'
                            ]),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Forms\Components\TextInput::make('rt')
                                ->required()
                                ->numeric()
                                ->minLength(3)
                                ->maxLength(3)
                                ->placeholder('Masukkan nomor RT, contoh: 003')
                                ->label('RT')
                                ->validationMessages([
                                    'required' => 'RT harus diisi.',
                                    'max_digits' => 'RT tidak boleh melebihi 3 digit angka.',
                                    'min_digits' => 'RT harus berisi 3 digit angka.'
                                ]),
                            Forms\Components\TextInput::make('rw')
                                ->required()
                                ->numeric()
                                ->label('RW')
                                ->placeholder('Masukkan nomor RW, contoh: 005')
                                ->minLength(3)
                                ->maxLength(3)
                                ->validationMessages([
                                    'required' => 'RW harus diisi.',
                                    'max_digits' => 'RW tidak boleh melebihi 3 digit angka.',
                                    'min_digits' => 'RW harus berisi 3 digit angka.'
                                ]),
                            Forms\Components\TextInput::make('village')
                                ->required()
                                ->maxLength(100)
                                ->label('Desa')
                                ->placeholder('Masukkan nama desa/kelurahan, contoh: Kelurahan Sukamaju')
                                ->validationMessages([
                                    'required' => 'Desa harus diisi.',
                                    'max' => 'Desa tidak boleh melebihi 100 karakter.'
                                ]),
                            Forms\Components\TextInput::make('district')
                                ->required()
                                ->label('Kecamatan')
                                ->maxLength(100)
                                ->placeholder('Masukkan nama kecamatan, contoh: Kecamatan Cilandak')
                                ->validationMessages([
                                    'required' => 'Kecamatan harus diisi.',
                                    'max' => 'Kecamatan tidak boleh melebihi 100 karakter.'
                                ]),
                            Forms\Components\TextInput::make('city')
                                ->required()
                                ->maxLength(100)
                                ->label('Kota')
                                ->placeholder('Masukkan nama kota/kabupaten, contoh: Kota Bandung')
                                ->validationMessages([
                                    'required' => 'Kota harus diisi.',
                                    'max' => 'Kota tidak boleh melebihi 100 karakter.'
                                ]),
                            Forms\Components\TextInput::make('postal_code')
                                ->required()
                                ->maxLength(5)
                                ->minLength(5)
                                ->numeric()
                                ->placeholder('Masukkan 5 digit kode pos, contoh: 12440')
                                ->label('Kode Pos')
                                ->validationMessages([
                                    'required' => 'Kode Pos harus diisi.',
                                    'max_digits' => 'Kode Pos tidak boleh melebihi 5 digit angka.',
                                    'min_digits' => 'Kode Pos harus berisi setidaknya 5 digit angka.'
                                ]),
                        ])
                    ]),
                Section::make('Akun Nasabah')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Forms\Components\TextInput::make('email')
                                ->required()
                                ->maxValue(255)
                                ->placeholder('Masukkan email aktif, contoh: budi.santoso@gmail.com')
                                ->email()
                                ->validationMessages([
                                    'required' => 'Email harus diisi.',
                                    'max' => 'Email tidak boleh lebih dari 255 karakter.',
                                    'unique' => 'Email sudah digunakan.',
                                    'email' => 'Email tidak valid.'
                                ])->rules([
                                    fn(): Closure => function (string $attribute, $value, Closure $fail) use ($form) {
                                        $userExists = DB::table('users')
                                            ->where('id', '!=', $form->getRecord()->user_id ?? '')
                                            ->where('email', $value)
                                            ->exists();

                                        if ($userExists) {
                                            $fail('Email sudah digunakan.');
                                        }
                                    }
                                ]),
                            Forms\Components\TextInput::make('password')
                                ->hidden(fn(string $context): bool => $context == 'view')
                                ->required(fn(string $context): bool => $context != 'edit')
                                ->password()
                                ->revealable()
                                ->placeholder('Minimal 8 karakter dengan kombinasi huruf dan angka')
                                ->maxValue(255)
                                ->minValue(8)
                                ->helperText(
                                    fn(string $context): string => $context == 'edit'
                                        ? 'Kosongkan jika tidak ingin diubah'
                                        : ''
                                )
                                ->validationMessages([
                                    'required' => 'Password harus diisi.',
                                    'max' => 'Password tidak boleh lebih dari 255 karakter.',
                                    'min' => 'Password harus berisi setidaknya 8 karakter.',
                                ]),
                        ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable()
                    ->sortable()
                    ->label('NIK')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap')
                    ->limit(20),
                Tables\Columns\TextColumn::make('place_of_birth')
                    ->searchable()
                    ->sortable()
                    ->label('Tempat Lahir')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->label('Tanggal Lahir')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable()
                    ->label('Telepon'),
                Tables\Columns\TextColumn::make('rt')
                    ->searchable()
                    ->sortable()
                    ->label('RT')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rw')
                    ->searchable()
                    ->sortable()
                    ->label('RW')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('village')
                    ->searchable()
                    ->sortable()
                    ->label('Desa')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('district')
                    ->searchable()
                    ->sortable()
                    ->label('Kecamatan')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->label('Kota')
                    ->toggleable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Pos')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->label('Alamat')
                    ->toggleable()
                    ->limit(20),
                Tables\Columns\ImageColumn::make('identity_card_photo')
                    ->searchable()
                    ->label('Foto')
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Saat'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diupdate Saat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(CustomerExporter::class)
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
