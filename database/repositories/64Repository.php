<?php

namespace App\Repositories;

use App\Models\64;
use Illuminate\Database\Eloquent\Collection;

class 64Repository {

    public function findById($id): ?64 {
        return 64::find($id);
    }

    public function getAll(): Collection {
        return 64::all();
    }

    public function create(array $data): 64 {
        return 64::create($data);
    }

    public function update($id, array $data): bool {
        return 64::find($id)->update($data);
    }

    public function delete($id): bool {
        return 64::destroy($id) > 0;
    }
}