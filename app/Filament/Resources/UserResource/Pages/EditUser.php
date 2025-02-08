<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;


class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate($record, array $data): \Illuminate\Database\Eloquent\Model
    {
    // Cek jika password diubah
    if (!empty($data['password'])) {
        // Enkripsi password yang baru
        $data['password'] = Hash::make($data['password']);
    }

    // Proses update user dengan data yang sudah ter-enkripsi
    return parent::handleRecordUpdate($record, $data);
    }
}
