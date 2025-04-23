<?php

namespace App\Filament\Pages;

use App\Models\CompanyProfile as ModelsCompanyProfile;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\DB;

class CompanyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Profil Bank Sampah';

    protected static string $view = 'filament.pages.company-profile';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public function mount(): void
    {
        $data = DB::table('company_profiles')->get([
            'name',
            'description',
            'address',
            'weighing_location',
            'annountcement',
            'account_number',
            'on_behalf',
            'balance',
            'sales_balance'
        ])->map(function ($item) {
            return (array) $item;
        });

        $this->form->fill($data[0]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil Utama')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxValue(100)
                                    ->label('Nama Bank')
                                    ->validationMessages([
                                        'required' => 'Nama bank harus diisi',
                                        'max' => 'Nama bank tidak boleh lebih dari 100 karakter.'
                                    ]),
                                Textarea::make('description')
                                    ->required()
                                    ->maxLength(2000)
                                    ->label('Deskripsi')
                                    ->autosize()
                                    ->validationMessages([
                                        'required' => 'Deskripsi harus diisi',
                                        'max' => 'Deskripsi tidak boleh lebih dari 2000 karakter.'
                                    ]),
                                Textarea::make('address')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Alamat')
                                    ->autosize()
                                    ->validationMessages([
                                        'required' => 'Alamat harus diisi',
                                        'max' => 'Alamat tidak boleh lebih dari 255 karakter.'
                                    ]),
                                Textarea::make('weighing_location')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Lokasi Penimbangan')
                                    ->autosize()
                                    ->validationMessages([
                                        'required' => 'Lokasi penimbangan harus diisi',
                                        'max' => 'Lokasi penimbangan tidak boleh lebih dari 255 karakter.'
                                    ]),
                            ])
                    ]),
                Section::make('Pengumuman')
                    ->schema([
                        RichEditor::make('annountcement')
                            ->required()
                            ->maxLength(2000)
                            ->label('Isi Pengumuman')
                            ->validationMessages([
                                'required' => 'Pengumuman harus diisi',
                                'max' => 'Pengumuman tidak boleh lebih dari 2000 karakter.'
                            ]),
                    ]),
                Section::make('Rekening')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            TextInput::make('account_number')
                                ->numeric()
                                ->required()
                                ->maxLength(15)
                                ->label('Nomor Rekening')
                                ->validationMessages([
                                    'required' => 'Nomor rekening harus diisi.',
                                    'max_digits' => 'Nomor rekening tidak boleh lebih dari 15 karakter.'
                                ]),
                            TextInput::make('on_behalf')
                                ->required()
                                ->label('Atas Nama')
                                ->maxLength(100)
                                ->validationMessages([
                                    'required' => 'Atas nama harus diisi',
                                    'max' => 'Atas nama tidak boleh lebih dari 100 karakter.'
                                ]),
                        ]),
                        TextInput::make('balance')
                            ->readOnly()
                            ->prefix('Rp.')
                            ->label('Saldo'),
                        TextInput::make('sales_balance')
                            ->readOnly()
                            ->prefix('Rp.')
                            ->label('Saldo Penjualan'),
                    ])
            ])->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $companyProfile  = ModelsCompanyProfile::first();
            $companyProfile->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'address' => $data['address'],
                'weighing_location' => $data['weighing_location'],
                'annountcement' => $data['annountcement'],
                'account_number' => $data['account_number'],
                'on_behalf' => $data['on_behalf']
            ]);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
