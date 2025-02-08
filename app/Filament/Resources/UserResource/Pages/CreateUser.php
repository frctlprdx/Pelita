<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;


class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Enkripsi password sebelum disimpan
        $data['password'] = Hash::make($data['password']);

        // Proses pembuatan user dengan data yang sudah di-hash
        return parent::handleRecordCreation($data);
    }
}
