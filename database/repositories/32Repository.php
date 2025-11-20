<?php

namespace App\Repositories;

use App\Models\32;
use Illuminate\Database\Eloquent\Collection;

class 32Repository {

    public function findById($id): ?32 {
        return 32::find($id);
    }

    public function getAll(): Collection {
        return 32::all();
    }

    public function create(array $data): 32 {
        return 32::create($data);
    }

    public function update($id, array $data): bool {
        return 32::find($id)->update($data);
    }

    public function delete($id): bool {
        return 32::destroy($id) > 0;
    }
}