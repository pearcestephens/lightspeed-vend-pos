<?php

namespace App\Repositories;

use App\Models\43;
use Illuminate\Database\Eloquent\Collection;

class 43Repository {

    public function findById($id): ?43 {
        return 43::find($id);
    }

    public function getAll(): Collection {
        return 43::all();
    }

    public function create(array $data): 43 {
        return 43::create($data);
    }

    public function update($id, array $data): bool {
        return 43::find($id)->update($data);
    }

    public function delete($id): bool {
        return 43::destroy($id) > 0;
    }
}