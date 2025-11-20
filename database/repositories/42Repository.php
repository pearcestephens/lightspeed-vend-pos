<?php

namespace App\Repositories;

use App\Models\42;
use Illuminate\Database\Eloquent\Collection;

class 42Repository {

    public function findById($id): ?42 {
        return 42::find($id);
    }

    public function getAll(): Collection {
        return 42::all();
    }

    public function create(array $data): 42 {
        return 42::create($data);
    }

    public function update($id, array $data): bool {
        return 42::find($id)->update($data);
    }

    public function delete($id): bool {
        return 42::destroy($id) > 0;
    }
}