<?php

use App\Models\Instansi;
use App\Models\User;
use App\Support\OfficialVillageAccount;
use Illuminate\Support\Facades\Hash;

function superAdminUser(): User
{
    return User::factory()->create([
        'role' => User::ROLE_SUPER_ADMIN,
        'status' => 'active',
        'instansi_id' => null,
    ]);
}

function officialVillagePayload(array $overrides = []): array
{
    return array_merge([
        'desa' => 'Desa Soreang',
        'nama' => 'Pemerintah Desa Soreang',
        'nama_pimpinan' => 'Kepala Desa Soreang',
        'email' => 'kepaladesa.soreang@example.test',
        'username' => 'kepaladesasoreang',
        'kontak' => '081234567890',
        'alamat' => 'Kantor Desa Soreang',
        'password' => 'KepalaDesa123',
        'password_confirmation' => 'KepalaDesa123',
    ], $overrides);
}

test('super admin can centrally create an official village account', function () {
    $response = $this
        ->actingAs(superAdminUser())
        ->post(route('superadmin.instansi.store'), officialVillagePayload());

    $response->assertRedirect(route('superadmin.instansi.index'));

    $this->assertDatabaseHas('instansi', [
        'nama' => 'Pemerintah Desa Soreang',
        'tipe' => OfficialVillageAccount::TYPE,
        'kelurahan' => 'Desa Soreang',
        'status' => 'aktif',
    ]);

    $admin = User::where('email', 'kepaladesa.soreang@example.test')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->role)->toBe(User::ROLE_ADMIN_KEPALA_DESA)
        ->and($admin->status)->toBe('active')
        ->and($admin->desa)->toBe('Desa Soreang')
        ->and(Hash::check('KepalaDesa123', $admin->password))->toBeTrue();
});

test('super admin cannot create two active official accounts for the same village', function () {
    Instansi::create([
        'nama' => 'Pemerintah Desa Soreang',
        'tipe' => OfficialVillageAccount::TYPE,
        'kelurahan' => 'Desa Soreang',
        'status' => 'aktif',
        'email' => 'existing.soreang@example.test',
    ]);

    $response = $this
        ->actingAs(superAdminUser())
        ->from(route('superadmin.instansi.create'))
        ->post(route('superadmin.instansi.store'), officialVillagePayload([
            'email' => 'new.soreang@example.test',
            'username' => 'newsoreang',
        ]));

    $response
        ->assertRedirect(route('superadmin.instansi.create'))
        ->assertSessionHasErrors('desa');

    expect(Instansi::where('tipe', OfficialVillageAccount::TYPE)
        ->where('kelurahan', 'Desa Soreang')
        ->whereIn('status', ['pending', 'aktif'])
        ->count())->toBe(1);
});

test('inactive official village account can be recreated for the same village', function () {
    Instansi::create([
        'nama' => 'Pemerintah Desa Soreang Lama',
        'tipe' => OfficialVillageAccount::TYPE,
        'kelurahan' => 'Desa Soreang',
        'status' => 'nonaktif',
        'email' => 'inactive.soreang@example.test',
    ]);

    $response = $this
        ->actingAs(superAdminUser())
        ->post(route('superadmin.instansi.store'), officialVillagePayload());

    $response->assertRedirect(route('superadmin.instansi.index'));

    expect(Instansi::where('tipe', OfficialVillageAccount::TYPE)
        ->where('kelurahan', 'Desa Soreang')
        ->count())->toBe(2);
});

test('non super admin cannot access centralized village account creation', function () {
    $user = User::factory()->create([
        'role' => User::ROLE_ADMIN_INSTANSI,
        'status' => 'active',
    ]);

    $this
        ->actingAs($user)
        ->get(route('superadmin.instansi.create'))
        ->assertForbidden();

    $this
        ->actingAs($user)
        ->post(route('superadmin.instansi.store'), officialVillagePayload())
        ->assertForbidden();
});
