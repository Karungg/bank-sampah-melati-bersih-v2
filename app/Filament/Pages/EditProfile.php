<?php

namespace App\Filament\Pages;

use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;
    public static string | Alignment $formActionsAlignment = Alignment::End;
    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm'
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi ' . __('filament-panels::pages/auth/edit-profile.label'))
                    ->aside()
                    ->description('Perbarui informasi profil akun dan alamat email anda.')
                    ->schema([
                        FileUpload::make('avatar_url')
                            ->label('Foto Profil')
                            ->maxSize(3072)
                            ->avatar()
                            ->imageEditor()
                            ->directory('avatars')
                            ->nullable()
                            ->placeholder('Unggah foto profil')
                            ->image(),
                        TextInput::make('name')
                            ->required()
                            ->maxValue(255)
                            ->label('Nama')
                            ->placeholder('Masukkan nama')
                            ->validationMessages([
                                'required' => 'Nama harus diisi.',
                                'max' => 'Nama tidak boleh lebih dari 255 karakter.'
                            ]),
                        TextInput::make('email')
                            ->required()
                            ->maxValue(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Masukkan email')
                            ->email()
                            ->validationMessages([
                                'required' => 'Email harus diisi.',
                                'max' => 'Email tidak boleh lebih dari 255 karakter.',
                                'unique' => 'Email sudah digunakan.',
                                'email' => 'Email tidak valid.'
                            ]),
                    ])
            ])->model($this->getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Perbarui Password')
                    ->aside()
                    ->description('Pastikan akun anda menggunakan password yang tidak mudah ditebak agar menjaga keamanan akun anda.')
                    ->schema([
                        TextInput::make('Current Password')
                            ->label('Password saat ini')
                            ->password()
                            ->maxValue(255)
                            ->required()
                            ->currentPassword()
                            ->validationMessages([
                                'required' => 'Password saat ini harus diisi.',
                                'max' => 'Password saat ini tidak boleh lebih dari 255 karakter.',
                                'current_password' => 'Password saat ini salah.'
                            ]),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxValue(255)
                            ->rule(Password::default())
                            ->autocomplete(false)
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation')
                            ->validationMessages([
                                'required' => 'Password harus diisi.',
                                'max' => 'Password tidak boleh lebih dari 255 karakter.',
                                'min' => 'Password harus berisi setidaknya 8 karakter.'
                            ]),
                        TextInput::make('passwordConfirmation')
                            ->password()
                            ->label('Konfirmasi password')
                            ->required()
                            ->maxValue(255)
                            ->dehydrated(false)
                            ->validationMessages([
                                'required' => 'Konfirmasi password saat ini harus diisi.',
                                'max' => 'Konfirmasi password saat ini tidak boleh lebih dari 255 karakter.',
                                'min' => 'Konfirmasi password harus berisi setidaknya 8 karakter.'
                            ])
                    ])
            ])->model($this->getUser())
            ->statePath('passwordData');
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new Exception('Terjadi kesalahan saat memproses.');
        }

        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill($data);
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm')
        ];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editPasswordForm')
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification();
    }

    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification();
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }

    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->send();
    }
}
