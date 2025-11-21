<?php

namespace App\Repositories;

use App\Models\30;
use Illuminate\Database\Eloquent\Collection;

class 30Repository {

    public function findById($id): ?30 {
        return 30::find($id);
    }

    public function getAll(): Collection {
        return 30::all();
    }

    public function create(array $data): 30 {
        return 30::create($data);
    }

    public function update($id, array $data): bool {
        return 30::find($id)->update($data);
    }

    public function delete($id): bool {
        return 30::destroy($id) > 0;
    }
}