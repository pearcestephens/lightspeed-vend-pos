<?php

namespace App\Repositories;

use App\Models\3;
use Illuminate\Database\Eloquent\Collection;

class 3Repository {

    public function findById($id): ?3 {
        return 3::find($id);
    }

    public function getAll(): Collection {
        return 3::all();
    }

    public function create(array $data): 3 {
        return 3::create($data);
    }

    public function update($id, array $data): bool {
        return 3::find($id)->update($data);
    }

    public function delete($id): bool {
        return 3::destroy($id) > 0;
    }
}