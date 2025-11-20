<?php

namespace App\Repositories;

use App\Models\69;
use Illuminate\Database\Eloquent\Collection;

class 69Repository {

    public function findById($id): ?69 {
        return 69::find($id);
    }

    public function getAll(): Collection {
        return 69::all();
    }

    public function create(array $data): 69 {
        return 69::create($data);
    }

    public function update($id, array $data): bool {
        return 69::find($id)->update($data);
    }

    public function delete($id): bool {
        return 69::destroy($id) > 0;
    }
}