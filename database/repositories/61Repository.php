<?php

namespace App\Repositories;

use App\Models\61;
use Illuminate\Database\Eloquent\Collection;

class 61Repository {

    public function findById($id): ?61 {
        return 61::find($id);
    }

    public function getAll(): Collection {
        return 61::all();
    }

    public function create(array $data): 61 {
        return 61::create($data);
    }

    public function update($id, array $data): bool {
        return 61::find($id)->update($data);
    }

    public function delete($id): bool {
        return 61::destroy($id) > 0;
    }
}