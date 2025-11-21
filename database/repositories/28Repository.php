<?php

namespace App\Repositories;

use App\Models\28;
use Illuminate\Database\Eloquent\Collection;

class 28Repository {

    public function findById($id): ?28 {
        return 28::find($id);
    }

    public function getAll(): Collection {
        return 28::all();
    }

    public function create(array $data): 28 {
        return 28::create($data);
    }

    public function update($id, array $data): bool {
        return 28::find($id)->update($data);
    }

    public function delete($id): bool {
        return 28::destroy($id) > 0;
    }
}