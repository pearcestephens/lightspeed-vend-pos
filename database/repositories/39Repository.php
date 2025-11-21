<?php

namespace App\Repositories;

use App\Models\39;
use Illuminate\Database\Eloquent\Collection;

class 39Repository {

    public function findById($id): ?39 {
        return 39::find($id);
    }

    public function getAll(): Collection {
        return 39::all();
    }

    public function create(array $data): 39 {
        return 39::create($data);
    }

    public function update($id, array $data): bool {
        return 39::find($id)->update($data);
    }

    public function delete($id): bool {
        return 39::destroy($id) > 0;
    }
}